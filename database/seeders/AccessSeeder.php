<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AccessSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole    = Role::where('name', 'admin')->first();
        $petugasRole  = Role::where('name', 'petugas')->first();

        $allMenus = Menu::all();
        $dashboardMenu = Menu::where('name', 'Dashboard')->pluck('id');

        // Admin akses semua menu
        if ($adminRole) {
            $adminRole->menus()->sync($allMenus->pluck('id'));
        }

        // Petugas hanya dashboard
        if ($petugasRole) {
            $petugasRole->menus()->sync($dashboardMenu);
        }
    }
}
