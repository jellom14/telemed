<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use JSend\JSendResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Validator;
use Illuminate\Support\Str;
use App\Models\User;

class MessagesController extends Controller
{

    public function createMessages(Request $request)
    {
        $data = $request->all();
        $rules = [
            // 'conversationId' => 'required',
            // 'fromUserId' => 'required',
            'toUserId' => 'required',
            'message' => 'required',
            // 'attachments' => 'required',
            // 'sentDate' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            // When a new meesage is created, check if any conversation has already taken place. 
            // If the conversation has already taken place, use the existing conversation ID

            $messagesCount = DB::table('messages')
                ->where(function ($query) use ($request) {
                    $query->where('fromUserId', '=', $request->user()->id)
                        ->where('toUserId', '=', $request->toUserId);
                })
                ->orWhere(function ($query) use ($request) {
                    $query->where('fromUserId', '=', $request->toUserId)
                        ->where('toUserId', '=', $request->user()->id);
                })->count();

            if ($messagesCount > 0) {
                // A conversation exists. So use the existing conversation Id
                $messages = DB::table('messages')
                    ->where(function ($query) use ($request) {
                        $query->where('fromUserId', '=', $request->user()->id)
                            ->where('toUserId', '=', $request->toUserId);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('fromUserId', '=', $request->toUserId)
                            ->where('toUserId', '=', $request->user()->id);
                    })
                    ->get()
                    ->values()
                    ->first();
                $conversationId = $messages->conversationId;

                try {
                    DB::beginTransaction();
                    $message = new Messages;
                    $message->conversationId = $conversationId;
                    $message->fromUserId = $request->user()->id;
                    $message->toUserId = $request->toUserId;
                    $message->message = $request->message;
                    $message->attachments = $request->attachments;
                    $message->sentDate = $request->sentDate;
                    $message->push();
                    DB::commit();
                    self::sendFCMnotification($request->toUserId, "Telemed", $message);
                    return JSendResponse::success();

                } catch (Exception $exc) {
                    DB::rollBack();
                    // Log the exception
                    Log::emergency($exc->getMessage());
                    return JSendResponse::error('Something went wrong. Please contact your project administrator for help explaining what you tried to do.');
                }

            } else {
                // No conversation exists. So create a new conversation Id

                $conversationId = (string) Str::uuid();
                try {
                    DB::beginTransaction();
                    $message = new Messages;
                    $message->conversationId = $conversationId;
                    $message->fromUserId = $request->user()->id;
                    $message->toUserId = $request->toUserId;
                    $message->message = $request->message;
                    $message->attachments = $request->attachments;
                    $message->sentDate = $request->sentDate;
                    $message->push();
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

    public function sendFCMnotification($toUserId, $title, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
        $user = User::query()
            ->where('id', '=', $toUserId)
            //                        ->where('active', '=', true)
            ->first();
        $FcmToken = $user['device_key'];
        

        $serverKey = config('app.FIREBASE_SERVER_KEY');

        $data = [
            "registration_ids" => array($FcmToken),
            "notification" => [
                "title" => $title,
                "body" => $message,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        
        
        if ($result === FALSE) {
            Log::alert(curl_error($ch));
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
    }

    public function getConversationsByUserId(Request $request)
    {
        $messages = DB::table('messages')
            ->join('users as fromUserTable', 'fromUserTable.id', '=', 'messages.fromUserId')
            ->join('users as toUserTable', 'toUserTable.id', '=', 'messages.toUserId')
            ->where('fromUserId', '=', $request->user()->id)
            ->orWhere('toUserId', '=', $request->user()->id)
            ->get(
                [
                    'messages.*',
                    'fromUserTable.userTypeId AS fromUserTypeId',
                    'fromUserTable.firstName AS fromUserFirstName',
                    'fromUserTable.lastName AS fromUserLastName',
                    'toUserTable.userTypeId AS toUserTypeId',
                    'toUserTable.firstName AS toUserFirstName',
                    'toUserTable.lastName AS toUserLastName',
                ]
            )
            ->all();
        if (count($messages) > 0) {
            return JsendResponse::success($messages);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }

    public function getMessagesByConversationId(Request $request)
    {
        $messages = DB::table('messages')
            ->join('users as fromUserTable', 'fromUserTable.id', '=', 'messages.fromUserId')
            ->join('users as toUserTable', 'toUserTable.id', '=', 'messages.toUserId')
            ->where('conversationId', '=', $request->conversationId)
            ->get(
                [
                    'messages.*',
                    'fromUserTable.userTypeId AS fromUserTypeId',
                    'fromUserTable.firstName AS fromUserFirstName',
                    'fromUserTable.lastName AS fromUserLastName',
                    'toUserTable.userTypeId AS toUserTypeId',
                    'toUserTable.firstName AS toUserFirstName',
                    'toUserTable.lastName AS toUserLastName',
                ]
            )
            ->all();
        if (count($messages) > 0) {
            return JsendResponse::success($messages);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
    }
}