<?php

namespace App\Http\Controllers;

use App\Models\Cader;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class CaderController extends Controller
{
    public function getCaders()
    {
        $caders = Cader::all()->sortBy('cader')->values()->all();
        if (count($caders) > 0) {
            return JsendResponse::success($caders);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}