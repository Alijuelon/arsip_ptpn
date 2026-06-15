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
        $depPersonalia = \App\Models\Departemen::create([
            'nama_departemen' => 'Personalia',
            'keterangan' => 'Departemen Personalia'
        ]);

        $depTataUsaha = \App\Models\Departemen::create([
            'nama_departemen' => 'Tata Usaha',
            'keterangan' => 'Departemen Tata Usaha'
        ]);

        $depTanaman = \App\Models\Departemen::create([
            'nama_departemen' => 'Tanaman',
            'keterangan' => 'Departemen Tanaman'
        ]);

        // Akun Admin
        User::create([
            'nama_user' => 'Nabila (Admin)',
            'nip' => '111111',
            'email' => 'Nabilaadmin51@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'Admin'
        ]);

        // Akun Pimpinan
        User::create([
            'nama_user' => 'Eka Suryadharmawan (Manager)',
            'nip' => '333333',
            'email' => 'ekasuryadharmawanmanager@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'Pimpinan'
        ]);

        // Akun Departemen Personalia
        User::create([
            'nama_user' => 'Sholahhuddin (Personalia)',
            'nip' => '222221',
            'email' => 'Sholahhuddinkaryawanpersonalia@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'Staff',
            'departemen_id' => $depPersonalia->id
        ]);

        // Akun Departemen Tata Usaha
        User::create([
            'nama_user' => 'Aang Supriyadi (Tata Usaha)',
            'nip' => '222222',
            'email' => 'aangsupriyadikaryawantatausaha@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'Staff',
            'departemen_id' => $depTataUsaha->id
        ]);

        // Akun Departemen Tanaman
        User::create([
            'nama_user' => 'Maulana (Tanaman)',
            'nip' => '222223',
            'email' => 'maulanapoday@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'Staff',
            'departemen_id' => $depTanaman->id
        ]);
    }
}
