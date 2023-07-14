<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use JSend\JSendResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Validator;

class MessagesController extends Controller
{

    public function createMessages(Request $request)
    {
        $data = $request->all();
        $rules = [
            // 'conversationId' => 'required',
            'fromUserId' => 'required',
            'toUserId' => 'required',
            'message' => 'required',
            'attachments' => 'required',
            'sentDate' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages['message'] = implode(",", $validator->getMessageBag()->all());
            return JSendResponse::fail($messages);
        } else {
            // When a new meesage is created, check if any conversation has already taken place. 
            // If the conversation has already taken place, use the existing conversation ID
            
            $messages = DB::table('messages')
                ->where(function ($query) use ($request){
                    $query->where('fromUserId', '=', $request->user()->id)->where('toUserId', '=', $request->toUserId);
                })
                ->where(['fromUserId', '=', $request->user()->id, 'toUserId', '=', $request->toUserId])
                ->orWhere(['toUserId', '=', $request->toUserId, 'fromUserId', '=', $request->user()->id])
                ->get()
                ->values()
                ->all();
                $messages['message'] = count($messages);
                return JSendResponse::fail($messages);
            // If the conversation is new, create a new conversation ID
            try {
                DB::beginTransaction();
                $message = new Messages;
                $message->conversationId = $request->conversationId;
                $message->fromUserId = $request->fromUserId;
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