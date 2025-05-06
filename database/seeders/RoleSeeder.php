<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/RoleSeeder.php

    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pegawai']);
        // Role::insert([
        //     ['name' => 'admin'],
        //     ['name' => 'pegawai'],
        // ]);
        // $admin = Role::where('name', 'admin')->first();
        // $pegawai = Role::where('name', 'pegawai')->first();

        // $user = User::first(); // atau cari user by email

        // if ($user) {
        //     $user->roles()->attach($admin->id); // assign role admin ke user pertama
        // }
    }
}
