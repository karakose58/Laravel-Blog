<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), 
        ]);


        User::create([
            'name' => 'writer',
            'email' => 'writer@gmail.com',
            'password' => Hash::make('password'), 
        ]);


        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);





        Role::create(['name' => 'admin']);
        $user = User::find(1); 
        $user->assignRole('admin');


        Role::create(['name' => 'writer']);
        $user = User::find(2); 
        $user->assignRole('writer');


        Role::create(['name' => 'user']);
        $user = User::find(3);
        $user->assignRole('user');   
     }
}
