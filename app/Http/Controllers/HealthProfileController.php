<?php

namespace App\Http\Controllers;

use App\Models\DrugAllergiesHealthProfileMap;
use App\Models\FamMedicalConditionsHealthProfileMap;
use App\Models\HealthProfile;
use App\Models\MedicalConditionsHealthProfileMap;
use App\Models\SurgeriesHealthProfileMap;
use App\Models\SymptomsHealthProfileMap;
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
            'caderId' => 'required',
            'allergicToDrugsComplaint' => 'required',
            'medications' => 'required',
            'medicalConditionComplaint' => 'required',
            'surgeryComplaint' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            try {
                DB::beginTransaction();
                $model = new HealthProfile;
                $model->lengthOfFeeling = $request->lengthOfFeeling;
                $model->patientId = $request->user()->id;
                $model->caderId = $request->caderId;
                $model->medications = $request->medications;
                $model->allergicToDrugsComplaint = $request->allergicToDrugsComplaint;
                $model->medicalConditionComplaint = $request->medicalConditionComplaint;
                $model->surgeryComplaint = $request->surgeryComplaint;
                $model->push();

                $symptomsCount = null;
                if ($request->symptomsModelList != null) {
                    $symptomsCount = count($request->symptomsModelList);
                }

                for ($idx = 0; $idx < $symptomsCount; $idx++) {
                    $symptomsHealthProfileMap = new SymptomsHealthProfileMap;
                    $symptomsHealthProfileMap->symptomId = $request->symptomsModelList[$idx]['id'];
                    $symptomsHealthProfileMap->healthProfileId = $model->id;
                    $symptomsHealthProfileMap->push();
                }
                
                $drugAllergiesCount = null;
                if ($request->drugAllergiesModelList != null) {
                    $drugAllergiesCount = count($request->drugAllergiesModelList);
                }

                for ($idx = 0; $idx < $drugAllergiesCount; $idx++) {
                    $drugAllergiesHealthProfileMap = new DrugAllergiesHealthProfileMap;
                    $drugAllergiesHealthProfileMap->allergyId = $request->medicalConditionsModelList[$idx]['id'];
                    $drugAllergiesHealthProfileMap->healthProfileId = $model->id;
                    $drugAllergiesHealthProfileMap->push();
                }

                $medicalConditionsCount = null;
                if ($request->medicalConditionsModelList != null) {
                    $medicalConditionsCount = count($request->medicalConditionsModelList);
                }

                for ($idx = 0; $idx < $medicalConditionsCount; $idx++) {
                    $medicalConditionsHealthProfileMap = new MedicalConditionsHealthProfileMap;
                    $medicalConditionsHealthProfileMap->medicalConditionId = $request->medicalConditionsModelList[$idx]['id'];
                    $medicalConditionsHealthProfileMap->healthProfileId = $model->id;
                    $medicalConditionsHealthProfileMap->push();
                }

                $surgeriesCount = null;
                if ($request->surgeriesModelList != null) {
                    $surgeriesCount = count($request->surgeriesModelList);
                }

                for ($idx = 0; $idx < $surgeriesCount; $idx++) {
                    $surgeriesHealthProfileMap = new SurgeriesHealthProfileMap;
                    $surgeriesHealthProfileMap->surgeryId = $request->surgeriesModelList[$idx]['id'];
                    $surgeriesHealthProfileMap->healthProfileId = $model->id;
                    $surgeriesHealthProfileMap->push();
                }

                $famMedicalConditionsCount = null;
                if ($request->famMedicalConditionsModelList != null) {
                    $famMedicalConditionsCount = count($request->famMedicalConditionsModelList);
                }

                for ($idx = 0; $idx < $famMedicalConditionsCount; $idx++) {
                    $famMedicalConditionsHealthProfileMap = new FamMedicalConditionsHealthProfileMap;
                    $famMedicalConditionsHealthProfileMap->medicalConditionId = $request->famMedicalConditionsModelList[$idx]['id'];
                    $famMedicalConditionsHealthProfileMap->healthProfileId = $model->id;
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
}