<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
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

    // Create a message by checking if the conversation has already occured between them. 
    // If conversation doesn't exist, create a conversation(create a unique conversationId)
    // If conversation exists, create a message using the conversationId.
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
            $toUserId = $request->toUserId;
            $fromUserId = $request->user()->id;

            Log::alert("from userId: " . $fromUserId);
            Log::alert("to userId: " . $toUserId);

            $conversationsCount = DB::table('conversations')
                ->where(function ($query) use ($fromUserId, $toUserId) {
                    $query->where('fromUserId', '=', $fromUserId)
                        ->where('toUserId', '=', $toUserId);
                })
                ->orWhere(function ($query) use ($fromUserId, $toUserId) {
                    $query->where('fromUserId', '=', $toUserId)
                        ->where('toUserId', '=', $fromUserId);
                })->count();

            if ($conversationsCount > 0) {
                // A conversation exists. So use the existing conversation Id
                $conversations = DB::table('conversations')
                    ->where(function ($query) use ($fromUserId, $toUserId) {
                        $query->where('fromUserId', '=', $fromUserId)
                            ->where('toUserId', '=', $toUserId);
                    })
                    ->orWhere(function ($query) use ($fromUserId, $toUserId) {
                        $query->where('fromUserId', '=', $toUserId)
                            ->where('toUserId', '=', $fromUserId);
                    })
                    ->get()
                    ->values()
                    ->first();

                $conversationId = $conversations->id;

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
                    self::sendFCMnotification($request->user()->id, $request->toUserId, "Telemed", $request->message);
                    return JSendResponse::success();

                } catch (Exception $exc) {
                    DB::rollBack();
                    // Log the exception
                    Log::emergency($exc->getMessage());
                    return JSendResponse::error('Something went wrong. Please contact your project administrator for help explaining what you tried to do.');
                }

            } else {
                // No conversation exists. So create a new conversation Id
                try {
                    DB::beginTransaction();

                    $conversation = new Conversations;
                    $conversation->fromUserId = $request->user()->id;
                    $conversation->toUserId = $request->toUserId;
                    $conversation->push();

                    $conversationId = $conversation->id;
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

    public function sendFCMnotification($fromUserId, $toUserId, $title, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

        // $req_user = User::query()
        //     ->where('id', '=', $fromUserId)
        //     //                        ->where('active', '=', true)
        //     ->first();

        // $userTypeId = $req_user['userTypeId'];
        // $user = User::query()
        //     ->where('id', '=', $toUserId)
        //     //                        ->where('active', '=', true)
        //     ->first();
        // // patient
        // if($userTypeId == 3){
        //     $user = User::query()
        //     ->where('id', '=', $toUserId)
        //     //                        ->where('active', '=', true)
        //     ->first();
        // }
        // // doctor
        // if($userTypeId == 2){

        // }
        // Log::alert("from userId: " . $fromUserId);
        // Log::alert("to userId: " . $toUserId);
        $user = User::query()
            ->where('id', '=', $toUserId)
            //                        ->where('active', '=', true)
            ->first();
        $FcmToken = $user['device_key'];
        // Log::alert($FcmToken);

        $serverKey = config('app.FIREBASE_SERVER_KEY');

        $data = [
            "registration_ids" => array($FcmToken),
            // "to" => json_encode(array($FcmToken)),
            "priority" => "high",
            "notification" => [
                "title" => $title,
                "body" => $message,
                "sound" => "default"
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
        // Log::alert(curl_exec($ch));

        if ($result === FALSE) {
            // Log::alert(curl_error($ch));
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        // dd($result);
    }

    public function getConversationsByUserId(Request $request)
    {
        // $data = $request->all();
        // $rules = [
        //     'toUserId' => 'required',
        // ];

        // $validator = Validator::make($data, $rules);
        // if ($validator->fails()) {
        //     $messages['message'] = implode(",", $validator->getMessageBag()->all());
        //     return JSendResponse::fail($messages);
        // } else {

        $fromUserId = $request->user()->id;
        $conversations = DB::table('conversations')
            ->where('fromUserId', '=', $fromUserId)
            ->orWhere('toUserId', '=', $fromUserId)

            // ->where(function ($query) use ($fromUserId) {
            //     $query->where('fromUserId', '=', $fromUserId);
            //         // ->where('toUserId', '=', $toUserId);
            // })
            // ->orWhere(function ($query) use ($fromUserId) {
            //     $query->where('toUserId', '=', $fromUserId);
            //         // ->where('toUserId', '=', $toUserId);
            // })

            // $messages = DB::table('messages')
            ->join('users as fromUserTable', 'fromUserTable.id', '=', 'conversations.fromUserId')
            ->join('users as toUserTable', 'toUserTable.id', '=', 'conversations.toUserId')
            ->where('fromUserId', '=', $fromUserId)
            ->orWhere('toUserId', '=', $fromUserId)
            ->get(
                [
                    'conversations.*',
                    'fromUserTable.userTypeId AS fromUserTypeId',
                    'fromUserTable.firstName AS fromUserFirstName',
                    'fromUserTable.lastName AS fromUserLastName',
                    'fromUserTable.device_key AS fromUserDeviceKey',
                    'toUserTable.userTypeId AS toUserTypeId',
                    'toUserTable.firstName AS toUserFirstName',
                    'toUserTable.lastName AS toUserLastName',
                    'toUserTable.device_key AS toUserDeviceKey',
                ]
            )
            // ->last();
            ->all();
        for ($idx = 0; $idx < count($conversations); $idx++) {
            $messages = DB::table('messages')
                ->join('users as fromUserTable', 'fromUserTable.id', '=', 'messages.fromUserId')
                ->join('users as toUserTable', 'toUserTable.id', '=', 'messages.toUserId')
                ->where('conversationId', '=', $conversations[$idx]->id)
                ->get(
                    [
                        'messages.*',
                        'fromUserTable.userTypeId AS fromUserTypeId',
                        'fromUserTable.firstName AS fromUserFirstName',
                        'fromUserTable.lastName AS fromUserLastName',
                        'fromUserTable.device_key AS fromUserDeviceKey',
                        'toUserTable.userTypeId AS toUserTypeId',
                        'toUserTable.firstName AS toUserFirstName',
                        'toUserTable.lastName AS toUserLastName',
                        'toUserTable.device_key AS toUserDeviceKey',
                    ]
                )
                ->last();
            $conversations[$idx]->message = $messages->message;
            $conversations[$idx]->sentDate = $messages->sentDate;
            // var_dump($conversations);
        }
        // var_dump($conversations[0]->id);
        // $messagesArray[] = $messages;
        // $messages = $messagesArray;
        if (count($conversations) > 0) {
            return JsendResponse::success($conversations);
        } else {
            $messages['message'] = 'No records found.';
            return JSendResponse::fail($messages);
        }
        // }
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
                    'fromUserTable.device_key AS fromUserDeviceKey',
                    'toUserTable.userTypeId AS toUserTypeId',
                    'toUserTable.firstName AS toUserFirstName',
                    'toUserTable.lastName AS toUserLastName',
                    'toUserTable.device_key AS toUserDeviceKey',
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