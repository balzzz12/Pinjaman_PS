<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            [
                'id'   => 1,
                'name' => 'admin',
                'ket'  => 'Administrator'
            ],
            [
                'id'   => 2,
                'name' => 'petugas',
                'ket'  => 'Petugas Operasional'
            ],
            [
                'id'   => 3,
                'name' => 'peminjam',
                'ket'  => 'Peminjam Alat'
            ],
        ]);
    }
}
