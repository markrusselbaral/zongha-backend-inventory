<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class AdminCredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Mark Russel Baral',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123')
        ]);
        $user->assignRole('admin');
    }
}
