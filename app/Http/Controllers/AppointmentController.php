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
use App\Models\DrugAllergiesAppointmentsMap;
use App\Models\FamMedicalConditionsAppointmentsMap;
use App\Models\MedicalConditionsAppointmentsMap;
use App\Models\SurgeriesAppointmentsMap;
use App\Models\SymptomsAppointmentsMap;

class AppointmentController extends Controller
{
    public function createAppointment(Request $request)
    {
        $data = $request->all();
        $rules = [
            'lengthOfFeeling' => 'required',
            'allergicToDrugsComplaint' => 'required',
            'medications' => 'required',
            'medicalConditionComplaint' => 'required',
            'surgeryComplaint' => 'required',
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
                // Health profile
                $model->lengthOfFeeling = $request->lengthOfFeeling;
                $model->patientId = $request->user()->id;
                $model->caderId = $request->caderId;
                $model->medications = $request->medications;
                $model->allergicToDrugsComplaint = $request->allergicToDrugsComplaint;
                $model->medicalConditionComplaint = $request->medicalConditionComplaint;
                $model->surgeryComplaint = $request->surgeryComplaint;
                // Appointments
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

                $symptomsCount = null;
                if ($request->symptomsModelList != null) {
                    $symptomsCount = count($request->symptomsModelList);
                }

                for ($idx = 0; $idx < $symptomsCount; $idx++) {
                    $symptomsHealthProfileMap = new SymptomsAppointmentsMap;
                    $symptomsHealthProfileMap->symptomId = $request->symptomsModelList[$idx]['id'];
                    $symptomsHealthProfileMap->appointmentId = $model->id;
                    $symptomsHealthProfileMap->push();
                }

                $drugAllergiesCount = null;
                if ($request->drugAllergiesModelList != null) {
                    $drugAllergiesCount = count($request->drugAllergiesModelList);
                }

                for ($idx = 0; $idx < $drugAllergiesCount; $idx++) {
                    $drugAllergiesHealthProfileMap = new DrugAllergiesAppointmentsMap;
                    $drugAllergiesHealthProfileMap->allergyId = $request->drugAllergiesModelList[$idx]['id'];
                    $drugAllergiesHealthProfileMap->appointmentId = $model->id;
                    $drugAllergiesHealthProfileMap->push();
                }

                $medicalConditionsCount = null;
                if ($request->medicalConditionsModelList != null) {
                    $medicalConditionsCount = count($request->medicalConditionsModelList);
                }

                for ($idx = 0; $idx < $medicalConditionsCount; $idx++) {
                    $medicalConditionsHealthProfileMap = new MedicalConditionsAppointmentsMap;
                    $medicalConditionsHealthProfileMap->medicalConditionId = $request->medicalConditionsModelList[$idx]['id'];
                    $medicalConditionsHealthProfileMap->appointmentId = $model->id;
                    $medicalConditionsHealthProfileMap->push();
                }

                $surgeriesCount = null;
                if ($request->surgeriesModelList != null) {
                    $surgeriesCount = count($request->surgeriesModelList);
                }

                for ($idx = 0; $idx < $surgeriesCount; $idx++) {
                    $surgeriesHealthProfileMap = new SurgeriesAppointmentsMap;
                    $surgeriesHealthProfileMap->surgeryId = $request->surgeriesModelList[$idx]['id'];
                    $surgeriesHealthProfileMap->appointmentId = $model->id;
                    $surgeriesHealthProfileMap->push();
                }

                $famMedicalConditionsCount = null;
                if ($request->famMedicalConditionsModelList != null) {
                    $famMedicalConditionsCount = count($request->famMedicalConditionsModelList);
                }

                for ($idx = 0; $idx < $famMedicalConditionsCount; $idx++) {
                    $famMedicalConditionsHealthProfileMap = new FamMedicalConditionsAppointmentsMap;
                    $famMedicalConditionsHealthProfileMap->medicalConditionId = $request->famMedicalConditionsModelList[$idx]['id'];
                    $famMedicalConditionsHealthProfileMap->appointmentId = $model->id;
                    $famMedicalConditionsHealthProfileMap->push();
                }

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
            ->join('users as doctorUser', 'doctorUser.id', '=', 'appointments.doctorId')
            ->join('users as patientUser', 'patientUser.id', '=', 'appointments.patientId')
            ->where('dateOfAppointment', '=', $request->dateOfAppointment)
            ->get(
                [
                    'appointments.*',
                    'doctorUser.firstName AS doctorUserFirstName',
                    'doctorUser.lastName AS doctorUserLastName',
                    'patientUser.firstName AS patientUserFirstName',
                    'patientUser.lastName AS patientUserLastName',
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
            ->join('users as doctorUser', 'doctorUser.id', '=', 'appointments.doctorId')
            ->join('users as patientUser', 'patientUser.id', '=', 'appointments.patientId')
            // ->join('symptomsAppointmentsMap', 'symptomsAppointmentsMap.appointmentId', '=', 'appointments.id')
            ->get(
                [
                    'appointments.*',
                    // 'symptomsAppointmentsMap.*',
                    'doctorUser.firstName AS doctorUserFirstName',
                    'doctorUser.lastName AS doctorUserLastName',
                    'patientUser.firstName AS patientUserFirstName',
                    'patientUser.lastName AS patientUserLastName',
                ]
            )
            ->sortBy('timeOfAppointment')
            // ->values()
            ->all();

        for ($idx = 0; $idx < count($appointments); $idx++) {
            $symptoms = DB::table('symptomsAppointmentsMap')
                ->join('meta_symptoms', 'meta_symptoms.id', '=', 'symptomsAppointmentsMap.symptomId')
                ->where('symptomsAppointmentsMap.appointmentId', '=', $appointments[$idx]->id)
                ->get(['symptomsAppointmentsMap.*', 'meta_symptoms.*'])
                ->values()
                ->all();
            $appointments[$idx]->symptomsModelList = $symptoms;

            $drugAllergies = DB::table('drugAllergiesAppointmentsMap')
                ->join('meta_drug_allergies', 'meta_drug_allergies.id', '=', 'drugAllergiesAppointmentsMap.allergyId')
                ->where('drugAllergiesAppointmentsMap.appointmentId', '=', $appointments[$idx]->id)
                ->get(['drugAllergiesAppointmentsMap.*', 'meta_drug_allergies.*'])
                ->values()
                ->all();
            $appointments[$idx]->drugAllergiesModelList = $drugAllergies;

            $medicalConditions = DB::table('medicalConditionsAppointmentsMap')
                ->join('meta_medical_conditions', 'meta_medical_conditions.id', '=', 'medicalConditionsAppointmentsMap.medicalConditionId')
                ->where('medicalConditionsAppointmentsMap.appointmentId', '=', $appointments[$idx]->id)
                ->get(['medicalConditionsAppointmentsMap.*', 'meta_medical_conditions.*'])
                ->values()
                ->all();
            $appointments[$idx]->medicalConditionsModelList = $medicalConditions;

            $famMedicalConditions = DB::table('famMedicalConditionsAppointmentsMap')
                ->join('meta_medical_conditions', 'meta_medical_conditions.id', '=', 'famMedicalConditionsAppointmentsMap.medicalConditionId')
                ->where('famMedicalConditionsAppointmentsMap.appointmentId', '=', $appointments[$idx]->id)
                ->get(['famMedicalConditionsAppointmentsMap.*', 'meta_medical_conditions.*'])
                ->values()
                ->all();
            $appointments[$idx]->famMedicalConditionsModelList = $famMedicalConditions;

            $surgeries = DB::table('surgeriesAppointmentsMap')
                ->join('meta_surgeries', 'meta_surgeries.id', '=', 'surgeriesAppointmentsMap.surgeryId')
                ->where('surgeriesAppointmentsMap.appointmentId', '=', $appointments[$idx]->id)
                ->get(['surgeriesAppointmentsMap.*', 'meta_surgeries.*'])
                ->values()
                ->all();
            $appointments[$idx]->surgeriesModelList = $surgeries;


        }


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

    // public function getHealthProfileByPatientId(Request $request)
    // {
    //     $data = $request->all();
    //     $rules = [
    //         'patientId' => 'required',
    //     ];
    //     $validator = Validator::make($data, $rules);
    //     if ($validator->fails()) {
    //         $messages['message'] = implode(",", $validator->getMessageBag()->all());
    //         return JSendResponse::fail($messages);
    //     } else {
    //         $patientId = $request->patientId;
    //         $healthProfile = DB::table('healthprofile')
    //             // ->join('users as doctorUser', 'doctorUser.id', '=', 'appointments.doctorId')
    //             // ->join('users as patientUser', 'patientUser.id', '=', 'appointments.patientId')
    //                 ->where('patientId', '=', $patientId)
    //                 ->get(
    //                     [
    //                         'healthprofile.*',
    //                         // 'doctorUser.firstName AS doctorUserFirstName',
    //                         // 'doctorUser.lastName AS doctorUserLastName',
    //                         // 'patientUser.firstName AS patientUserFirstName',
    //                         // 'patientUser.lastName AS patientUserLastName',
    //                     ]
    //                 )
    //             //     ->sortBy('timeOfAppointment')
    //             ->values()
    //             ->all();
    //         if (count($healthProfile) > 0) {
    //             return JsendResponse::success($healthProfile);
    //         } else {
    //             $messages['message'] = 'No records found.';
    //             return JSendResponse::fail($messages);
    //         }
    //     }
    // }

}