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

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 1;
        $user->email = 'drenciso@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Rose';
        $user->lastName = 'Enciso';
        $user->address = 'PH';
        $user->dob = '01/27/1965';
        $user->bloodPressure = '70';
        $user->bloodType = 'A+';
        $user->gender = 'Female';
        $user->phone = '1234567890';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 1;
        $user->email = 'drmorales@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Victoria';
        $user->lastName = 'Morales';
        $user->address = 'PH';
        $user->dob = '06/27/1970';
        $user->bloodPressure = '70';
        $user->bloodType = 'A+';
        $user->gender = 'Female';
        $user->phone = '1234567890';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 2;
        $user->email = 'drafable@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Malou';
        $user->lastName = 'Afable';
        $user->address = 'PH';
        $user->dob = '06/23/1963';
        $user->bloodPressure = '68';
        $user->bloodType = 'AB+';
        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 3;
        $user->email = 'drrenato@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Renato';
        $user->lastName = 'Gomez';
        $user->address = 'PH';
        $user->dob = '11/17/1967';
        $user->bloodPressure = '60.3';
        $user->bloodType = 'O+';
        $user->gender = 'Male';
        $user->phone = '1234567890';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 4;
        $user->email = 'drtere@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Tere';
        $user->lastName = 'Sita';
        $user->address = 'PH';
        $user->dob = '01/25/1978';
        $user->bloodPressure = '80';
        $user->bloodType = 'B';
        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 5;
        $user->email = 'draragon@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Vicky';
        $user->lastName = 'Aragon';
        $user->address = 'PH';
        $user->dob = '05/25/1969';
        $user->bloodPressure = '85';
        $user->bloodType = 'A';
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