<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::find(1);

        if ($user) {
            $user->update([
                'name' => 'Root Root',
                'login' => 'root',
                'email' => 'root@root.com',
                'password' => Hash::make('root'),
                'role' => 'superadmin',
                'phone_number' => NULL
            ]);
        }
    }
}

