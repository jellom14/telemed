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
        // DB::table('userTypes')->truncate();

        // Admin - 1
        DB::table('userTypes')->insert([
            'userType' => 'Admin',
        ]);

        // // Doctor - 2
        DB::table('userTypes')->insert([
            'userType' => 'Doctor',
        ]);

        // // Patient - 3
        DB::table('userTypes')->insert([
            'userType' => 'Patient',
        ]);
    }

}