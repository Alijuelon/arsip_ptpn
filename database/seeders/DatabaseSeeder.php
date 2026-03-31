<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::create([
            'nama_user' => 'Super Admin',
            'nip' => '111111',
            'email' => 'admin@ptpn4.co.id',
            'password' => Hash::make('123456'),
            'role' => 'Admin' // Harus sesuai Enum di database ('Admin', 'Staff', 'Pimpinan')
        ]);

        // 2. Akun Karyawan / Staff
        User::create([
            'nama_user' => 'Budi Santoso',
            'nip' => '222222',
            'email' => 'karyawan@ptpn4.co.id',
            'password' => Hash::make('123456'),
            'role' => 'Staff'
        ]);

        // 3. Akun Pimpinan
        User::create([
            'nama_user' => 'Bapak Pimpinan',
            'nip' => '333333',
            'email' => 'pimpinan@ptpn4.co.id',
            'password' => Hash::make('123456'),
            'role' => 'Pimpinan'
        ]);
    }
    }

