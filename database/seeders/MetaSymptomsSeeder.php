<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\MetaSymptoms;

class MetaSymptomsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('caders')->truncate();

        $model = new MetaSymptoms;
        $model->symptom = 'Difficulty in sleeping';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Fever';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Mood changes';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Fatigue/Weakness';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Loss of appetite';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Night sweats';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Congestions';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Eye redness';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Loss of smell';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Ear pain';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Headaches';
        $model->save();

        $model = new MetaSymptoms;
        $model->symptom = 'Loss of taste';
        $model->save();

    }

}