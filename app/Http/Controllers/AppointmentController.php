<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JSend\JSendResponse;
use Illuminate\Support\Facades\DB;
use Validator;
use Exception;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function createAppointment(Request $request)
    {
        $data = $request->all();
        $rules = [
            'doctorId' => 'required',
            'patientId' => 'required',
            'caderId' => 'required',
            'dateOfAppointment' => 'required',
            'timeOfAppointment' => 'required',
            'complaint' => 'required',
            'pwdIdNumber' => 'required',
            'pwdIdExpirationDate' => 'required',
            'paymentReferenceNumber' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            try {
                DB::beginTransaction();
                $model = new Appointment;
                $model->doctorId = $request->doctorId;
                $model->patientId = $request->user()->id;
                $model->caderId = $request->caderId;
                $model->dateOfAppointment = $request->dateOfAppointment;
                $model->timeOfAppointment = $request->timeOfAppointment;
                $model->complaint = $request->complaint;
                $model->pwdIdNumber = $request->pwdIdNumber;
                $model->pwdIdExpirationDate = $request->pwdIdExpirationDate;
                $model->paymentReferenceNumber = $request->paymentReferenceNumber;
                $model->push();

                DB::commit();
                return JSendResponse::success();
            } catch (Exception $exc) {
                DB::rollBack();
                // Log the exception
                Log::emergency($exc->getMessage());
                return JSendResponse::error('Something went wrong. Please contact your project administrator for help explaining what you tried to do.');
            }
        }
    }

    public function getAppointmentByDate(Request $request)
    {
        $appointments = DB::table('appointments')
            ->join('users', 'users.id', '=', 'appointments.doctorId')
            ->where('dateOfAppointment', '=', $request->dateOfAppointment)
            ->get(
                [
                    'appointments.*',
                    'users.firstName',
                    'users.lastName',
                ]
            )
            ->sortBy('timeOfAppointment')
            ->values()
            ->all();

        // $appointments = Appointment::all()
        //     ->join('farms', 'farms.id', '=', 'flocks.farmId')
        //     ->where('dateOfAppointment', '=', $request->dateOfAppointment)
        //     ->sortBy('timeOfAppointment')
        //     ->values()
        //     ->all();
        if (count($appointments) > 0) {
            return JsendResponse::success($appointments);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }

    public function getAppointment(Request $request)
    {
        $appointments = DB::table('appointments')
            ->join('users', 'users.id', '=', 'appointments.doctorId')
            ->get(
                [
                    'appointments.*',
                    'users.firstName',
                    'users.lastName',
                ]
            )
            ->sortBy('timeOfAppointment')
            ->values()
            ->all();

        // $appointments = Appointment::all()
        //     ->join('farms', 'farms.id', '=', 'flocks.farmId')
        //     ->where('dateOfAppointment', '=', $request->dateOfAppointment)
        //     ->sortBy('timeOfAppointment')
        //     ->values()
        //     ->all();
        if (count($appointments) > 0) {
            return JsendResponse::success($appointments);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }

}