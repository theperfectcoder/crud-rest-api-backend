<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@admin.com',
             'phone' => 12345678,
             'password' => Hash::make('password'),
             'is_admin' => 1,
         ]);
    }
}
