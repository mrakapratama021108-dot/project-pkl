<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pegawai Staf Operasional
        User::updateOrCreate(
            ['email' => 'pegawai@paud.kemdikbud.go.id'],
            [
                'name' => 'Ahmad Subagja',
                'password' => Hash::make('PAUD2026!'),
                'role' => 'Pegawai',
            ]
        );

        // 2. Akun Reviewer (Tim Pengelola BMN)
        User::updateOrCreate(
            ['email' => 'tim.bmn@paud.kemdikbud.go.id'],
            [
                'name' => 'Dedi Kurniawan, S.T.',
                'password' => Hash::make('BMN2026!'),
                'role' => 'Reviewer (Tim BMN)',
            ]
        );

        // 3. Akun Approver (Kasubag Tata Usaha)
        User::updateOrCreate(
            ['email' => 'kasubag.tu@paud.kemdikbud.go.id'],
            [
                'name' => 'Dr. Bambang Sutrisno, M.Pd.',
                'password' => Hash::make('Kasubag2026!'),
                'role' => 'Approver (Kasubag TU)',
            ]
        );
    }
}