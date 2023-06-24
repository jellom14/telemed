<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Cader;

class CadersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caders')->truncate();

        $cader = new Cader;
        $cader->cader = 'Family Physicians';
        $cader->caderDescription = 'Health care specialist';
        $cader->save();

        $cader = new Cader;
        $cader->cader = 'Cardiologist';
        $cader->caderDescription = 'Heart specialist';
        $cader->save();

        $cader = new Cader;
        $cader->cader = 'Neurologist';
        $cader->caderDescription = 'Brain specialist';
        $cader->save();

        $cader = new Cader;
        $cader->cader = 'Dentist';
        $cader->caderDescription = 'Dental Surgeon';
        $cader->save();

        $cader = new Cader;
        $cader->cader = 'Opthalmologist';
        $cader->caderDescription = 'Eye specialist';
        $cader->save();

    }

}