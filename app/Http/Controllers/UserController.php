<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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
        $rulesForPatientAccount = [
            'userTypeId' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'address' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required',
        ];
        $rulesForDoctorAccount = [
            'userTypeId' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'qualificationId' => 'required',
            'specialityId' => 'required',
            'medicalSchoolOfGraduation' => 'required',
            'boardCertified' => 'required',
            'pdeaRegistrationNumber' => 'required',
            'currentMedicalLicenseNumber' => 'required',
            'currentMedicalLicenseNumberDateIssued' => 'required',
        ];
        $validator = null;
        $userTypeId = $request->userTypeId;
        // Doctor
        if ($userTypeId == 2) {
            $validator = Validator::make($data, $rulesForDoctorAccount);
        }
        // Patient
        if ($userTypeId == 3) {
            $validator = Validator::make($data, $rulesForPatientAccount);
        }

        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            try {
                $user = new User;
                $user->userTypeId = $request->userTypeId;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->firstName = $request->firstName;
                $user->lastName = $request->lastName;
                $user->address = $request->address;
                $user->dob = $request->dob;
                $user->bloodPressure = $request->bloodPressure;
                $user->bloodType = $request->bloodType;
                $user->gender = $request->gender;
                $user->phone = $request->phone;
                $user->videoConsultationFee = $request->videoConsultationFee;
                $user->qualificationId = $request->qualificationId;
                $user->specialityId = $request->specialityId;
                $user->medicalSchoolOfGraduation = $request->medicalSchoolOfGraduation;
                $user->boardCertified = $request->boardCertified;
                $user->pdeaRegistrationNumber = $request->pdeaRegistrationNumber;
                $user->currentMedicalLicenseNumber = $request->currentMedicalLicenseNumber;
                $user->currentMedicalLicenseNumberDateIssued = $request->currentMedicalLicenseNumberDateIssued;
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
                        $userData['id'] = $user['id'];
                        $userData['email'] = $user['email'];
                        $userData['firstName'] = $user['firstName'];
                        $userData['lastName'] = $user['lastName'];
                        $userData['gender'] = $user['gender'];
                        $userData['dob'] = $user['dob'];
                        $userData['phone'] = $user['phone'];
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

    public function getDoctorsByCaderId(Request $request)
    {
        $caderId = $request->get('caderId');
        $doctors = DB::table('users')
            ->where('users.userTypeId', '=', 2)
            ->where('users.cadersId', '=', $caderId)
            ->get()
            ->all();
        if (count($doctors) > 0) {
            return JsendResponse::success($doctors);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}