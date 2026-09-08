<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pegawai
        User::create([
            'name' => 'Budi (Pegawai)',
            'email' => 'pegawai@bmn.go.id',
            'password' => Hash::make('password'),
            'role' => 'Pegawai',
        ]);

        // 2. Akun Reviewer
        User::create([
            'name' => 'Siti (Reviewer BMN)',
            'email' => 'reviewer@bmn.go.id',
            'password' => Hash::make('password'),
            'role' => 'Reviewer (Tim BMN)',
        ]);

        // 3. Akun Approver
        User::create([
            'name' => 'Pak Ahmad (Kasubag TU)',
            'email' => 'approver@bmn.go.id',
            'password' => Hash::make('password'),
            'role' => 'Approver (Kasubag TU)',
        ]);
    }
}