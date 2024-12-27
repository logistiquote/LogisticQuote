<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User;
        $user->name = 'John Doe';
        $user->role = 'user';
        $user->phone = '+012 345 6789';
        $user->country = 'UK';
        $user->company_name = 'Co. United';
        $user->email = 'user@test.com';
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();
        //

        //
        $user = new User;
        $user->name = 'John Doe';
        $user->role = 'admin';
        $user->phone = '+012 345 6789';
        $user->country = 'UK';
        $user->company_name = 'Co. United';
        $user->email = 'admin@test.com';
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
