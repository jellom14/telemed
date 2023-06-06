<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
   //for testing purposes only

   public function post(Request $request){ //CREATE SERVICE
    $validated=$request->validate([
        'name'=>'required|max:20'
    ]);

    $service=new Service($validated);
    $service->save();

    return response()->json($service,Response::HTTP_OK);
}

public function put($id,Request $request){ //UPDATE SERVICE
    $validated=$request->validate([
        'name'=>'required|max:20'
    ]);
    
    $service=Service::find($id);
    $service->update($validated);
    
    return response()->json($service,Response::HTTP_OK);

}

public function get($id){ //READ SERVICE
    $service=Service::find($id);

    return response()->json($service,Response::HTTP_OK);
}

public function delete($id){ //DELETE SERVICE
    $service=Service::find($id);
    $service->delete();

    return response()->json($service,Response::HTTP_OK);
}

public function index(Request $request){ //SEARCH SERVICE
    
    $pageSize = $request->page_size ?? 20;

    $service = Service::query()
    ->where("name", "LIKE", "%Doctor%")
    ->paginate($pageSize);
    
     return  response()->json($service, Response::HTTP_OK);
    
}

}
