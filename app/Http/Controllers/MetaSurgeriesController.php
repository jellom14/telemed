<?php

namespace App\Http\Controllers;

use App\Models\MetaSurgeries;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class MetaSurgeriesController extends Controller
{
    public function getSurgeries()
    {
        $modelList = MetaSurgeries::all()->sortBy('surgeryName')->values()->all();
        if (count($modelList) > 0) {
            return JsendResponse::success($modelList);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}