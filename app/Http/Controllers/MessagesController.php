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