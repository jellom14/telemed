<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffController extends Controller
{
    //for testing purposes only

    public function post(AddStaffRequest $request){ //CREATE STAFF
 
        $staff=new Staff($request->validated());
        $staff->save();

        return response()->json($staff,Response::HTTP_OK);
    }

    public function put($id,UpdateStaffRequest $request){ //UPDATE STAFF
   
        $staff=Staff::find($id);
        $staff->update($request->validated());
        
        return response()->json($staff,Response::HTTP_OK);

    }

    public function get($id){ //READ STAFF
        $staff=Staff::find($id);

        return response()->json($staff,Response::HTTP_OK);
    }

    public function delete($id){ //DELETE STAFF
        $staff=Staff::find($id);
        $staff->delete();

        return response()->json($staff,Response::HTTP_OK);
    }

    public function index(Request $request){ //SEARCH STAFF
        
        $pageSize = $request->page_size ?? 20;

        $staff = Staff::query()
        ->where("first_name", "LIKE", "%Jello%")
        ->where("role_id", 1)
        ->with("role")
        ->paginate($pageSize);
        
         return  response()->json($staff, Response::HTTP_OK);

    }
}
