<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    //for testing purposes only

    public function post(AddAppointmentRequest $request){ //CREATE PATIENT
 
        $appointment=new Appointment($request->validated());
        $appointment->save();

        return response()->json($appointment,Response::HTTP_OK);
    }

    public function put($id,UpdateAppointmentRequest $request){ //UPDATE PATIENT
   
        $appointment=Appointment::find($id);
        $appointment->update($request->validated());
        
        return response()->json($appointment,Response::HTTP_OK);

    }

    public function get($id){ //READ PATIENT
        $appointment=Appointment::find($id);

        return response()->json($appointment,Response::HTTP_OK);
    }

    public function delete($id){ //DELETE PATIENT
        $appointment=Appointment::find($id);
        $appointment->delete();

        return response()->json($appointment,Response::HTTP_OK);
    }

    public function index(Request $request){ //SEARCH PATIENT
        
        $pageSize = $request->page_size ?? 20;

        $appointment = Appointment::query()
        ->where("name", "LIKE", "%Jello%")
        ->where("service_id", 1)
        ->with("service")
        ->paginate($pageSize);
        
         return  response()->json($appointment, Response::HTTP_OK);

    }
}
