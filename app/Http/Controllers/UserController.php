<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use JSend\JSendResponse;
use Exception;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function createAccount(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required|string|max:255',
            'userTypeId' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            try {
                $user = new User;
                $user->name = $request->name;
                $user->userTypeId = $request->userTypeId;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->saveOrFail();
                return JSendResponse::success();
            } catch (Exception $exc) {
                // Log the exception
                Log::emergency($exc->getMessage());
                return JSendResponse::error('Something went wrong. Please contact your project administrator for help explaining what you tried to do.');
            }
        }
    }

    public function signIn(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            try {
                $email = $request->input('email');
                $password = $request->input('password');
                $user = User::query()
                    ->where('email', '=', $email)
                    //                        ->where('active', '=', true)
                    ->first();
                if ($user == null) {
                    $messages['message'] = "Either user doesn't exist or isn't active. Please contact your project administrator for help explaining what you tried to do.";
                    return JSendResponse::fail($messages);
                } else {
                    if (Hash::check($password, $user['password'])) {
                        $id = $user['id'];
                        $userData['name'] = $user['name'];
                        $userData['email'] = $user['email'];
                        $userData['token'] = $user->createToken('auth_token')->plainTextToken;
                        //                        $userData['token'] = $user->createToken('auth_token')->plainTextToken;
                        return JSendResponse::success($userData);
                    } else {
                        $messages['message'] = 'Incorrect credentials.';
                        return JSendResponse::fail($messages);
                    }
                }
            } catch (Exception $exc) {
                // Log the exception
                Log::emergency($exc->getMessage());
                return JSendResponse::error('Something went wrong. Please contact your project administrator for help explaining what you tried to do.');
            }
        }
    }
}