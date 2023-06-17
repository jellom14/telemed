<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
  //for testing purposes only

  public function post(Request $request){ //CREATE MESSAGE
    $validated=$request->validate([
    'patient_id'=>'nullable|string', 'staff_id'=>'nullable|string', 'message'=>'required|max:20'
    ]);

    $message=new Message($validated);
    $message->save();

    return response()->json($message,Response::HTTP_OK);
}

public function put($id,Request $request){ //UPDATE MESSAGE
    $validated=$request->validate([
    'patient_id'=>'nullable|string', 'staff_id'=>'nullable|string', 'message'=>'required|max:20'

    ]);
    
    $message=Message::find($id);
    $message->update($validated);
    
    return response()->json($message,Response::HTTP_OK);

}

public function get($id){ //READ MESSAGE
    $message=Message::find($id);

    return response()->json($message,Response::HTTP_OK);
}

public function delete($id){ //DELETE MESSAGE
    $message=Message::find($id);
    $message->delete();

    return response()->json($message,Response::HTTP_OK);
}

public function index(Request $request){ //SEARCH MESSAGE
    
    $pageSize = $request->page_size ?? 20;

    $message = Message::query()
    ->where("name", "LIKE", "%Doctor%")
    ->paginate($pageSize);
    
     return  response()->json($message, Response::HTTP_OK);
    
}
}
