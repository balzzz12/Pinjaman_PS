<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\User;
use App\Models\PlayStation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        logAktivitas(
            'Akses Halaman Peminjaman',
            'Admin membuka halaman peminjaman'
        );

        $peminjaman = Sewa::with(['user', 'playstation'])->latest()->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Sewa::with(['user', 'playstation'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $sewa = Sewa::findOrFail($id);

        // ✅ LOG EDIT (dibuka halaman edit)
        logAktivitas(
            'Buka Form Edit',
            'ID: ' . $sewa->id . ' | User: ' . $sewa->user->name
        );

        return view('admin.peminjaman.edit', [
            'sewa' => $sewa,
            'users' => User::all(),
            'playstations' => PlayStation::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $sewa = Sewa::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'playstation_id' => 'required|exists:play_stations,id',
            'durasi' => 'required|integer|min:1|max:7',
            'status' => 'nullable|string'
        ]);

        $statusLama = $sewa->status;

        if ($request->status == 'dipinjam' && $sewa->status != 'dipinjam') {

            $ps = PlayStation::find($sewa->playstation_id);

            if ($ps->stok <= 0) {
                return back()->with('error', 'Stok habis!');
            }

            $ps->decrement('stok');
        }

        $sewa->update($request->only(['user_id', 'playstation_id', 'durasi', 'status']));

        // ✅ LOG UPDATE DETAIL
        logAktivitas(
            'Update Peminjaman',
            'ID: ' . $sewa->id .
                ' | User: ' . $sewa->user->name .
                ' | PS: ' . $sewa->playstation->nama .
                ' | Status: ' . $statusLama . ' → ' . $sewa->status
        );

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $sewa = Sewa::findOrFail($id);

        $info = 'User: ' . $sewa->user->name . ' | PS: ' . $sewa->playstation->nama;

        if ($sewa->status !== 'selesai') {
            $sewa->playstation->increment('stok');
        }

        $sewa->delete();

        // ✅ LOG DELETE
        logAktivitas('Hapus Peminjaman', $info);

        return back()->with('success', 'Data berhasil dihapus');
    }
    public function konfirmasi($id)
    {
        $sewa = Sewa::findOrFail($id);

        if ($sewa->status === 'dipinjam') {
            $sewa->playstation->increment('stok');

            $sewa->update([
                'status' => 'selesai'
            ]);

            // ✅ LOG KONFIRMASI
            logAktivitas(
                'Konfirmasi Pengembalian',
                'ID: ' . $sewa->id .
                    ' | User: ' . $sewa->user->name .
                    ' | PS: ' . $sewa->playstation->nama
            );

            return back()->with('success', 'Pengembalian dikonfirmasi');
        }

        return back()->with('error', 'Status tidak valid');
    }

    public function pengembalian()
    {
        $peminjaman = Sewa::with(['user', 'playstation'])
            ->whereIn('status', ['menunggu_konfirmasi', 'selesai'])
            ->latest()
            ->get();

        // ✅ LOG AKSES HALAMAN
        logAktivitas('Akses Halaman Pengembalian', 'Admin membuka halaman pengembalian');

        return view('admin.peminjaman.pengembalian', compact('peminjaman'));
    }
}
