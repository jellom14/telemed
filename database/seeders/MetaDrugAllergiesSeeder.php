<?php

namespace Database\Seeders;

use App\Models\MetaDrugAllergies;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MetaDrugAllergiesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('caders')->truncate();

        $model = new MetaDrugAllergies;
        $model->drugName = 'Amoxicillin';
        $model->save();

        $model = new MetaDrugAllergies;
        $model->drugName = 'Bactrim';
        $model->save();

        $model = new MetaDrugAllergies;
        $model->drugName = 'Aspirin';
        $model->save();

        $model = new MetaDrugAllergies;
        $model->drugName = 'Penincillin';
        $model->save();

        $model = new MetaDrugAllergies;
        $model->drugName = 'Others';
        $model->save();


    }

}