<?php

namespace Database\Seeders;

use App\Models\DoctorSpecialities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Cader;

class DoctorSpecialitiesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('doctorsqualification')->truncate();

        $doctorSpeciality = new DoctorSpecialities;
        $doctorSpeciality->speciality = 'Family medicine';
        $doctorSpeciality->save();

        $doctorSpeciality = new DoctorSpecialities;
        $doctorSpeciality->speciality = 'Cardiology';
        $doctorSpeciality->save();

        $doctorSpeciality = new DoctorSpecialities;
        $doctorSpeciality->speciality = 'Neurology';
        $doctorSpeciality->save();

        $doctorSpeciality = new DoctorSpecialities;
        $doctorSpeciality->speciality = 'Dentistry';
        $doctorSpeciality->save();

        $doctorSpeciality = new DoctorSpecialities;
        $doctorSpeciality->speciality = 'Ophthalmology';
        $doctorSpeciality->save();

        $doctorQualification = new DoctorSpecialities;
        $doctorQualification->speciality = 'Pediatrics';
        $doctorQualification->save();

        $doctorQualification = new DoctorSpecialities;
        $doctorQualification->speciality = 'Psychiatry';
        $doctorQualification->save();



    }

}