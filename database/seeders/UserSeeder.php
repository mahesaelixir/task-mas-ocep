<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        // Buat user pegawai
        $pegawai = User::create([
            'name' => 'pegawai',
            'email' => 'pegawai@gmail.com',
            'password' => bcrypt('pegawai123'),
        ]);
        $pegawaiRole = Role::where('name', 'pegawai')->first();
        if ($pegawaiRole) {
            $pegawai->roles()->attach($pegawaiRole->id);
        }
    }
}
