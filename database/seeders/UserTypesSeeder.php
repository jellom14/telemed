<?php

namespace Database\Seeders;

use App\Models\UserTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserTypesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('usertypes')->truncate();

        // Admin - 1
        DB::table('usertypes')->insert([
            'userType' => 'Admin',
        ]);

        // // Doctor - 2
        DB::table('usertypes')->insert([
            'userType' => 'Doctor',
        ]);

        // // Patient - 3
        DB::table('usertypes')->insert([
            'userType' => 'Patient',
        ]);
    }

}