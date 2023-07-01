<?php

namespace App\Http\Controllers;

use App\Models\MetaDrugAllergies;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class MetaDrugAllergiesController extends Controller
{
    public function getDrugAllergies()
    {
        $modelList = MetaDrugAllergies::all()->sortBy('drugName')->values()->all();
        if (count($modelList) > 0) {
            return JsendResponse::success($modelList);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}