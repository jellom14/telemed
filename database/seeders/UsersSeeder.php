<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        // ADMIN
        $user = new User;
        $user->userTypeId = 1;
        $user->email = 'jello@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Jello';
        $user->lastName = 'Monasterial';
        $user->address = 'PH';
        $user->dob = '01/01/2023';
        $user->bloodPressure = '90';
        $user->bloodType = 'A+';
        $user->gender = 'male';
        $user->phone = '1234567890';
        $user->save();

        // DOCTOR
        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 3;
        $user->email = 'jona@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Jona';
        $user->lastName = 'Quirimit';
        $user->address = 'PH';
        $user->dob = '01/01/2023';
        $user->bloodPressure = '90';
        $user->bloodType = 'O+';
        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->save();

        // PATIENT
        $user = new User;
        $user->userTypeId = 3;
        $user->email = 'roby@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Roby';
        $user->lastName = 'Sulit';
        $user->address = 'PH';
        $user->dob = '01/01/2023';
        $user->bloodPressure = '90';
        $user->bloodType = 'B+';
        $user->gender = 'male';
        $user->phone = '1234567890';
        $user->save();

    }

}