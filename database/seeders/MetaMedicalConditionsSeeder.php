<?php

namespace Database\Seeders;

use App\Models\MetaMedicalConditions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MetaMedicalConditionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('caders')->truncate();

        $model = new MetaMedicalConditions;
        $model->medicalCondition = 'High Cholesterol';
        $model->save();

        $model = new MetaMedicalConditions;
        $model->medicalCondition = 'Insomnia';
        $model->save();

        $model = new MetaMedicalConditions;
        $model->medicalCondition = 'Asthma';
        $model->save();

        $model = new MetaMedicalConditions;
        $model->medicalCondition = 'Headaches';
        $model->save();

        $model = new MetaMedicalConditions;
        $model->medicalCondition = 'Stomach Ache';
        $model->save();

        $model = new MetaMedicalConditions;
        $model->medicalCondition = 'Others';
        $model->save();


    }

}