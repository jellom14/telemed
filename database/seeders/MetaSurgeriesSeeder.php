<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\MetaSurgeries;

class MetaSurgeriesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('caders')->truncate();

        $model = new MetaSurgeries;
        $model->surgeryName = 'Eye surgery';
        $model->save();

        $model = new MetaSurgeries;
        $model->surgeryName = 'Knee replacement';
        $model->save();

        $model = new MetaSurgeries;
        $model->surgeryName = 'Heart surgery';
        $model->save();

        $model = new MetaSurgeries;
        $model->surgeryName = 'Appendectomy';
        $model->save();

        $model = new MetaSurgeries;
        $model->surgeryName = 'Others';
        $model->save();


    }

}