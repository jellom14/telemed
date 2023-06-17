<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    //for testing purposes only

    public function post(AddPatientRequest $request){ //CREATE PATIENT
 
        $patient=new Patient($request->validated());
        $patient->save();

        return response()->json($patient,Response::HTTP_OK);
    }

    public function put($id,UpdatePatientRequest $request){ //UPDATE PATIENT
   
        $patient=Patient::find($id);
        $patient->update($request->validated());
        
        return response()->json($patient,Response::HTTP_OK);

    }

    public function get($id){ //READ PATIENT
        $patient=Patient::find($id);

        return response()->json($patient,Response::HTTP_OK);
    }

    public function delete($id){ //DELETE PATIENT
        $patient=Patient::find($id);
        $patient->delete();

        return response()->json($patient,Response::HTTP_OK);
    }

    public function index(Request $request){ //SEARCH PATIENT
        
        $pageSize = $request->page_size ?? 20;

        $patient = Patient::query()
        ->where("first_name", "LIKE", "%Jello%")
        ->where("role_id", 3)
        ->with("role")
        ->paginate($pageSize);
        
         return  response()->json($patient, Response::HTTP_OK);

    }



}
