<?php

namespace App\Http\Controllers;

use App\Models\DoctorQualifications;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class DoctorQualificationsController extends Controller
{
    public function getDoctorQualifications()
    {
        $doctorQualifications = DoctorQualifications::all()->sortBy('qualification')->values()->all();
        if (count($doctorQualifications) > 0) {
            return JsendResponse::success($doctorQualifications);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}