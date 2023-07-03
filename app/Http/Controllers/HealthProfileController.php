<?php

namespace App\Http\Controllers;

use App\Models\HealthProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use JSend\JSendResponse;
use Exception;

class HealthProfileController extends Controller
{
    public function __construct()
    {

    }

    public function createHealthProfile(Request $request)
    {
        $data = $request->all();
        $rules = [
            'lengthOfFeeling' => 'required',
            'patientId' => 'required',
            'caderId' => 'required',
            'allergicToDrugsComplaint' => 'required',
            'medications' => 'required',
            'medicalConditionComplaint' => 'required',
            'surgeryComplaint' => 'required',
            'pwdNumber' => 'required',
            'paymentReferenceNumber' => 'required',
        ];
        
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            try {
                $model = new HealthProfile;
                $model->lengthOfFeeling = $request->lengthOfFeeling;
                $model->patientId = $request->patientId;
                $model->caderId = $request->caderId;
                $model->medications = $request->medications;
                $model->allergicToDrugsComplaint = $request->allergicToDrugsComplaint;
                $model->medicalConditionComplaint = $request->medicalConditionComplaint;
                $model->surgeryComplaint = $request->surgeryComplaint;
                $model->pwdNumber = $request->pwdNumber;
                $model->paymentReferenceNumber = $request->paymentReferenceNumber;
                $model->saveOrFail();
                return JSendResponse::success();
            } catch (Exception $exc) {
                // Log the exception
                Log::emergency($exc->getMessage());
                return JSendResponse::error('Something went wrong. Please contact your project administrator for help explaining what you tried to do.');
            }
        }
    }
}