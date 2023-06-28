<?php

namespace App\Http\Controllers;

use App\Models\DoctorSpecialities;
use Illuminate\Http\Request;
use JSend\JSendResponse;

class DoctorSpecialitiesController extends Controller
{
    public function getDoctorSpecialities()
    {
        $doctorSpecialities = DoctorSpecialities::all()->sortBy('speciality')->values()->all();
        if (count($doctorSpecialities) > 0) {
            return JsendResponse::success($doctorSpecialities);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}