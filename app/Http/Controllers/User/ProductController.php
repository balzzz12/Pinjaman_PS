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

        $playstations = PlayStation::with('category')
            ->where('stok', '>', 0); // 🔥 hanya tampil yg tersedia

        if ($request->filled('category')) {
            $playstations->where('category_id', $request->category);
        }

        return view('user.products.index', [
            'categories'   => $categories,
            'playstations' => $playstations->latest()->get()
        ]);
    }

    // =======================
    // FORM SEWA
    // =======================
    public function create($id)
    {
        $ps = PlayStation::where('stok', '>', 0)->findOrFail($id);

        return view('user.sewa.create', compact('ps'));
    }

    // =======================
    // SIMPAN TRANSAKSI
    // =======================
    public function store(Request $request)
    {
        $request->validate([
           'playstation_id' => 'required|exists:play_stations,id',
            'durasi'         => 'required|integer|min:1|max:30',
            'aksi'           => 'required|in:pinjam,booking',

            'nama'   => 'required|string|max:100',
            'email'  => 'required|email',
            'no_ktp' => 'required|string|max:20',
            'hp'     => 'required|string|max:15',
            'alamat' => 'required|string',

            'dokumen.*' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $ps = PlayStation::lockForUpdate()
                ->findOrFail($request->playstation_id);

            if ($request->aksi === 'pinjam' && $ps->stok < 1) {
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

            $sewa = Sewa::create([
                'user_id'        => $user->id,
                'playstation_id' => $ps->id,
                'durasi'         => $request->durasi,
                'dokumen'        => json_encode($request->dokumen ?? []),
                'aksi'           => $request->aksi,
                'total_harga'    => $total,
                'status'         => $request->aksi === 'pinjam' ? 'menunggu' : 'booking'
            ]);

            // ✅ LOG AKTIVITAS
            logAktivitas(
                'Sewa Produk',
                'User menyewa PS: ' . $ps->nama . ' | ID Sewa: ' . $sewa->id
            );

            DB::commit();

            return redirect()->route('sewa.riwayat')
                ->with('success', 'Berhasil! Tunggu persetujuan petugas.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
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

        if ($sewa->status !== 'dipinjam') {
            return back()->with('error', 'Belum bisa dikembalikan.');
        }

        return view('user.sewa.kembali', compact('sewa'));
    }

    // =======================
    // USER SUBMIT PENGEMBALIAN
    // =======================
    public function kembali(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required|in:baik,rusak',
            'catatan_kembali' => 'nullable|string',
            'foto_kembali' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $sewa = Sewa::where('user_id', Auth::id())
            ->lockForUpdate()
            ->findOrFail($id);

        if ($sewa->status !== 'dipinjam') {
            return back()->with('error', 'Barang belum dipinjam.');
        }

        if ($request->hasFile('foto_kembali')) {
            $foto = $request->file('foto_kembali')
                ->store('pengembalian', 'public');

            $sewa->foto_kembali = $foto;
        }

        $sewa->update([
            'status'           => 'menunggu_konfirmasi',
            'kondisi'          => $request->kondisi,
            'catatan_kembali'  => $request->catatan_kembali
        ]);

        // ✅ LOG AKTIVITAS
        logAktivitas(
            'Pengajuan Pengembalian',
            'User mengajukan pengembalian | ID Sewa: ' . $sewa->id
        );

        return redirect()->route('sewa.riwayat')
            ->with('success', 'Menunggu konfirmasi petugas.');
    }
}
