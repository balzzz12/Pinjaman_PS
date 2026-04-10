<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $logs = LogAktivitas::with('user.role')

            ->when($request->role, function ($query) use ($request) {
                $query->whereHas('user.role', function ($q) use ($request) {
                    $q->where('name', $request->role);
                });
            })

            ->latest()
            ->paginate(10);

        return view('admin.log-aktivitas.index', compact('logs'));
    }
}
