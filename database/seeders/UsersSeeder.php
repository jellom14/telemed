<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->truncate();
        // DOCTOR
        $user = new User;
        $user->name = 'Jello';
        $user->userTypeId = 1;
        $user->email = 'jello@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        // DOCTOR
        $user = new User;
        $user->name = 'Jona';
        $user->userTypeId = 2;
        $user->email = 'jona@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        // PATIENT
        $user = new User;
        $user->name = 'Roby';
        $user->userTypeId = 3;
        $user->email = 'roby@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();
        
    }

}
