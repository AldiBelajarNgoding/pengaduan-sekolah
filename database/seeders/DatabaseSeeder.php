<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Sekolah',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $categories = ['Fasilitas', 'Kebersihan', 'Akademik', 'Keamanan'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}
