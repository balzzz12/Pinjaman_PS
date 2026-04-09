<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sewa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Notifikasi
use App\Notifications\PeminjamanDisetujui;
use App\Notifications\PeminjamanDitolak;

class PeminjamanController extends Controller
{
    // =========================
    // LIST SEMUA PEMINJAMAN
    // =========================
    public function index()
    {
        $peminjaman = Sewa::with(['user', 'playstation'])
            ->latest()
            ->get();

        // ✅ FIX VIEW
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    // =========================
    // SETUJUI
    // =========================
    public function setujui($id)
    {
        DB::beginTransaction();

        try {

            $sewa = Sewa::with(['playstation', 'user'])
                ->lockForUpdate()
                ->findOrFail($id);

            if ($sewa->status !== 'menunggu') {
                DB::rollBack();
                return back()->with('error', 'Transaksi sudah diproses.');
            }

            if ($sewa->playstation->stok < 1) {
                DB::rollBack();
                return back()->with('error', 'Stok sudah habis.');
            }

            $sewa->update([
                'status' => 'disetujui',
                'booking_code' => $sewa->booking_code ?? 'BOOK-' . strtoupper(Str::random(6)),
            ]);

            $sewa->user->notify(new PeminjamanDisetujui($sewa));

            DB::commit();

            return back()->with('success', 'Peminjaman disetujui.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    // =========================
    // SERAHKAN
    // =========================
    public function serahkan($id)
    {
        DB::beginTransaction();

        try {

            $sewa = Sewa::with('playstation')->findOrFail($id);

            if ($sewa->status !== 'disetujui') {
                DB::rollBack();
                return back()->with('error', 'Belum disetujui.');
            }

            if ($sewa->playstation->stok < 1) {
                DB::rollBack();
                return back()->with('error', 'Stok habis saat serah barang.');
            }

            $sewa->playstation->decrement('stok');

            $sewa->update([
                'status' => 'dipinjam',
                'waktu_mulai' => now()
            ]);

            DB::commit();

            return back()->with('success', 'Barang berhasil diserahkan.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    // =========================
    // TOLAK
    // =========================
    public function tolak($id)
    {
        $sewa = Sewa::with('user')->findOrFail($id);

        if ($sewa->status !== 'menunggu') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        $sewa->update([
            'status' => 'ditolak'
        ]);

        $sewa->user->notify(new PeminjamanDitolak($sewa));

        return back()->with('success', 'Peminjaman ditolak.');
    }

    // =========================
    // LIST PENGEMBALIAN
    // =========================
    public function pengembalian()
    {
        $peminjaman = Sewa::with(['user', 'playstation'])
            ->whereIn('status', ['menunggu_konfirmasi', 'selesai'])
            ->latest()
            ->get();

        return view('petugas.peminjaman.pengembalian', compact('peminjaman'));
    }

    // =========================
    // SELESAI
    // =========================
    public function selesai(Request $request, $id)
    {

        DB::beginTransaction();

        try {

            $sewa = Sewa::with('playstation')->findOrFail($id);

            if ($sewa->status !== 'menunggu_konfirmasi') {
                return back()->with('error', 'Belum ada pengajuan pengembalian.');
            }

            $sewa->playstation->increment('stok');
            $sewa->update([
                'status' => 'selesai',
                'waktu_selesai' => now()
            ]);

            DB::commit();

            return back()->with('success', 'Transaksi selesai + denda diproses');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem');
        }
    }

    // =========================
    // CETAK 1 USER
    // =========================
    public function cetakSatu($id)
    {
        $sewa = Sewa::with(['user', 'playstation'])
            ->findOrFail($id);

        return view('petugas.peminjaman.cetak_satu', compact('sewa'));
    }
}
