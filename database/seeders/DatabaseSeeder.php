<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);

        // Menambahkan role ke user
        $admin = User::find(1); // Misal admin pertama
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        $pegawai = User::find(2); // Misal pegawai kedua
        $pegawai->roles()->attach(Role::where('name', 'pegawai')->first());

    }
}
