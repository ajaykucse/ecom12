<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        // $admin = new Admin;
        // $admin->name = 'Ajay Kumar Yadav';
        // $admin->role = 'admin';
        // $admin->mobile = '9800000000';
        // $admin->email = 'admin@gmail.com';
        // $admin->password = $password;
        // $admin->status = 1;
        // $admin->save();

        $admin = new Admin;
        $admin->name = 'Ajay Yadav';
        $admin->role = 'subadmin';
        $admin->mobile = '9700000000';
        $admin->email = 'ajay@admin.com';
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();

        $admin = new Admin;
        $admin->name = 'John';
        $admin->role = 'subadmin';
        $admin->mobile = '9600000000';
        $admin->email = 'john@admin.com';
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();

    }
}
