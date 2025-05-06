<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole->id);

        $pegawai = User::create([
            'name' => 'pegawai',
            'email' => 'pegawai@gmail.com',
            'password' => bcrypt('pegawai123'),
        ]);
        $pegawaiRole = Role::where('name', 'pegawai')->first();
        $pegawai->roles()->attach($pegawaiRole->id);
    }
}
