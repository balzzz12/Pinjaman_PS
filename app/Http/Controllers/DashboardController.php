<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PlayStation;
use App\Models\Category;
use App\Models\Sewa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ✅ PINDAH KE SINI

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // DATA USER & MENU
        // =========================
        $userData = session('user_data');
        $role = $userData['role'] ?? null;

        $menuNames = session('user_data.menus', []);

        $menus = Menu::whereIn('name', $menuNames)
            ->orderBy('parent_id')
            ->orderBy('order')
            ->get()
            ->groupBy('parent_id');

        // =========================
        // DATA ADMIN
        // =========================
        $totalPS = PlayStation::count();
        $totalKategori = Category::count();
        $totalSewa = Sewa::count();
        $totalUser = User::count();
        $sewaAktif = Sewa::where('status', 'dipinjam')->count();

        $sewaTerbaru = Sewa::with('playstation')
            ->latest()
            ->take(5)
            ->get();

        // =========================
        // DATA GRAFIK (PER HARI)
        // =========================
        $grafik = Sewa::select(
            DB::raw('DAYOFWEEK(created_at) as hari'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        $namaHari = [
            1 => 'Minggu',
            2 => 'Senin',
            3 => 'Selasa',
            4 => 'Rabu',
            5 => 'Kamis',
            6 => 'Jumat',
            7 => 'Sabtu',
        ];

        $dataHari = [
            'Senin' => 0,
            'Selasa' => 0,
            'Rabu' => 0,
            'Kamis' => 0,
            'Jumat' => 0,
            'Sabtu' => 0,
            'Minggu' => 0,
        ];

        foreach ($grafik as $g) {
            $hariNama = $namaHari[$g->hari];
            $dataHari[$hariNama] = $g->total;
        }

        $chartLabels = array_keys($dataHari);
        $chartData = array_values($dataHari);

       // =========================
// DATA PETUGAS
// =========================
$pendingPeminjaman = Sewa::where('status', 'pending')->count();

$pendingPengembalian = Sewa::where('status', 'dikembalikan')->count();

$bookingPending = Sewa::with('playstation')
    ->where('status', 'menunggu')
    ->get();

$sewaHariIni = Sewa::with('playstation')
    ->whereDate('created_at', now())
    ->get();

$pengembalianHariIni = Sewa::with('playstation')
    ->whereDate('tanggal_selesai', now())
    ->get();

        // =========================
        // KIRIM KE VIEW
        // =========================
      return view('dashboard.index', compact(
    'userData',
    'menus',
    'role',
    'totalPS',
    'totalKategori',
    'totalSewa',
    'sewaAktif',
    'totalUser',
    'sewaTerbaru',
    'chartLabels',
    'chartData',
    'bookingPending',
    'sewaHariIni',
    'pengembalianHariIni',
    'pendingPeminjaman',
    'pendingPengembalian'
));
    }
}
