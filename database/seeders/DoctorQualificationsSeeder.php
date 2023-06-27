<?php

namespace Database\Seeders;

use App\Models\DoctorQualifications;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Cader;

class DoctorQualificationsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('doctorsqualification')->truncate();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'MD';
        $doctorQualification->save();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'BM';
        $doctorQualification->save();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'BS';
        $doctorQualification->save();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'MBBS';
        $doctorQualification->save();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'ChB';
        $doctorQualification->save();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'BMedSci';
        $doctorQualification->save();

        $doctorQualification = new DoctorQualifications;
        $doctorQualification->qualification = 'MSc';
        $doctorQualification->save();



    }

}