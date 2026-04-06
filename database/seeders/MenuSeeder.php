<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dashboard = Menu::create([
            'name' => 'Dashboard',
            'url' => 'dashboard',
            'icon' => 'fas fa-home',
            'order' => 1,
        ]);

        $users = Menu::create([
            'name' => 'User Management',
            'url' => 'pageUsers',
            'icon' => 'fas fa-users',
            'order' => 2,
        ]);

        $menuManagement = Menu::create([
            'name' => 'Menu Management',
            'url' => '#', // tidak diarahkan, hanya untuk dropdown
            'icon' => 'fas fa-list',
            'order' => 3,
        ]);

        Menu::create([
            'name' => 'Utama',
            'url' => 'pageMenus',
            'order' => 1,
            'parent_id' => $menuManagement->id,
        ]);

        Menu::create([
            'name' => 'SubMenu',
            'url' => 'pageSubMenus',
            'order' => 2,
            'parent_id' => $menuManagement->id,
        ]);

        $roles = Menu::create([
            'name' => 'Role Management',
            'url' => 'pageRoles',
            'icon' => 'fas fa-user-shield',
            'order' => 4,
        ]);
    }
}
