<?php

namespace App\Http\Controllers;

use App\Models\MetaMedicalConditions;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class MetaMedicalConditionsController extends Controller
{
    public function getMedicalConditions()
    {
        $modelList = MetaMedicalConditions::all()->sortBy('medicalCondition')->values()->all();
        if (count($modelList) > 0) {
            return JsendResponse::success($modelList);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}