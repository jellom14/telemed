<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeController extends Controller
{
   //for testing purposes only

   public function post(Request $request){ //CREATE MODE
    $validated=$request->validate([
        'name'=>'required|max:20',
    ]);

    $mode=new Mode($validated);
    $mode->save();

    return response()->json($mode,Response::HTTP_OK);
}

public function put($id,Request $request){ //UPDATE MODE
    $validated=$request->validate([
        'name'=>'required|max:20',
    ]);
    
    $mode=Mode::find($id);
    $mode->update($validated);
    
    return response()->json($mode,Response::HTTP_OK);

}

public function get($id){ //READ MODE
    $mode=Mode::find($id);

    return response()->json($mode,Response::HTTP_OK);
}

public function delete($id){ //DELETE MODE
    $mode=Mode::find($id);
    $mode->delete();

    return response()->json($mode,Response::HTTP_OK);
}

public function index(Request $request){ //SEARCH MODE
    
    $pageSize = $request->page_size ?? 20;

    $mode = Mode::query()
    ->where("name", "LIKE", "%Doctor%")
    ->paginate($pageSize);
    
     return  response()->json($mode, Response::HTTP_OK);
    
}

}
