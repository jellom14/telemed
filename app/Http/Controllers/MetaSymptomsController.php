<?php

namespace App\Http\Controllers;

use App\Models\MetaSymptoms;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class MetaSymptomsController extends Controller
{
    public function getSymptoms()
    {
        $modelList = MetaSymptoms::all()->sortBy('symptom')->values()->all();
        if (count($modelList) > 0) {
            return JsendResponse::success($modelList);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}