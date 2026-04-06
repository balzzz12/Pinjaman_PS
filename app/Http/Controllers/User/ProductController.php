<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PlayStation;
use App\Models\Category;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // =======================
    // LIST PRODUK
    // =======================
    public function index(Request $request)
    {
        $categories = Category::withCount('playstations')->get();

        $playstations = PlayStation::with('category');

        if ($request->filled('category')) {
            $playstations->where('category_id', $request->category);
        }

        return view('user.products.index', [
            'categories'   => $categories,
            'playstations' => $playstations->get()
        ]);
    }

    // =======================
    // FORM SEWA
    // =======================
    public function create($id)
    {
        $ps = PlayStation::findOrFail($id);
        return view('user.sewa.create', compact('ps'));
    }

    // =======================
    // SIMPAN TRANSAKSI
    // =======================
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $ps = PlayStation::where('id', $request->playstation_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($request->aksi === 'pinjam' && $ps->stok < 1) {
                DB::rollBack();
                return back()->with('error', 'Stok sedang habis.');
            }

            $total = $ps->harga * $request->durasi;

            $user = Auth::user();

            $user->update([
                'name'   => $request->nama,
                'email'  => $request->email,
                'no_ktp' => $request->no_ktp,
                'hp'     => $request->hp,
                'alamat' => $request->alamat
            ]);

            Sewa::create([
                'user_id'        => $user->id,
                'playstation_id' => $ps->id,
                'durasi'         => $request->durasi,
                'dokumen'        => json_encode($request->input('dokumen', [])),
                'aksi'           => $request->aksi,
                'total_harga'    => $total,
                'status'         => $request->aksi === 'pinjam' ? 'menunggu' : 'booking'
            ]);

            DB::commit();

            return back()->with('success', 'Sewa berhasil! Silahkan tunggu petugas ACC');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // =======================
    // RIWAYAT SEWA USER
    // =======================
    public function riwayat()
    {
        $sewas = Sewa::with('playstation')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.sewa.riwayat', compact('sewas'));
    }

    // =======================
    // FORM PENGEMBALIAN
    // =======================
    public function formKembali($id)
    {
        $sewa = Sewa::with('playstation')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.sewa.kembali', compact('sewa'));
    }

    // =======================
    // USER SUBMIT PENGEMBALIAN
    // =======================
    public function kembali(Request $request, $id)
    {
        $sewa = Sewa::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($sewa->status !== 'dipinjam') {
            return back()->with('error', 'Barang belum dipinjam.');
        }

        $request->validate([
            'kondisi' => 'required',
            'catatan_kembali' => 'nullable',
            'foto_kembali' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto_kembali')) {
            $foto = $request->file('foto_kembali')
                ->store('pengembalian', 'public');

            $sewa->foto_kembali = $foto;
        }

        $sewa->status = 'menunggu_konfirmasi';
        $sewa->kondisi = $request->kondisi;
        $sewa->catatan_kembali = $request->catatan_kembali;

        $sewa->save();

        return redirect()->route('sewa.riwayat')
            ->with('success', 'Menunggu konfirmasi petugas');
    }
}