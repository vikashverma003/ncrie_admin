<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class admin_table_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'Admin User',
            'email'=>'admin@code-brew.com', 
            'password'=>Hash::make('password'),
            'account_status'=>config('constants.account_status.ACTIVE')
        ]);
    }
}
