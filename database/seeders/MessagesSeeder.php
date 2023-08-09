<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Messages;

class MessagesSeeder extends Seeder
{

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('caders')->truncate();

    $messages = new Messages;
    $messages->conversationId = 1;
    $messages->fromUserId = 9;
    $messages->toUserId = 6;
    $messages->message = 'Shall we have a zoom meeting in a while? Let me paste a loooooooooooooooooooooooooooooong text.';
    $messages->sentDate = '2023-07-12';
    $messages->readDate = '2023-07-12';
    $messages->attachments = '{
            "attachments": [
              "abc.png",
              "def.png",
              "ghi.png"
            ]
          }';
    $messages->save();

    $messages = new Messages;
    $messages->conversationId = 1;
    $messages->fromUserId = 6;
    $messages->toUserId = 9;
    $messages->message = 'Alright Roby!';
    $messages->sentDate = '2023-07-12';
    $messages->readDate = '2023-07-12';
    $messages->attachments = '{
            "attachments": [
              "abc.png",
              "def.png",
              "ghi.png"
            ]
          }';
    $messages->save();

    $messages = new Messages;
    $messages->conversationId = 1;
    $messages->fromUserId = 6;
    $messages->toUserId = 9;
    $messages->message = 'Please make sure you have eaten your meal before the call.';
    $messages->sentDate = '2023-07-12';
    $messages->readDate = '2023-07-12';
    $messages->attachments = '{
            "attachments": [
              "abc.png",
              "def.png",
              "ghi.png"
            ]
          }';
    $messages->save();

    $messages = new Messages;
    $messages->conversationId = 2;
    $messages->fromUserId = 9;
    $messages->toUserId = 8;
    $messages->message = 'Hello Jona';
    $messages->sentDate = '2023-07-12';
    $messages->readDate = '2023-07-12';
    $messages->attachments = '{
            "attachments": [
              "abc.png",
              "def.png",
              "ghi.png"
            ]
          }';
    $messages->save();

    $messages = new Messages;
    $messages->conversationId = 3;
    $messages->fromUserId = 5;
    $messages->toUserId = 8;
    $messages->message = 'Hello Jello';
    $messages->sentDate = '2023-07-12';
    $messages->readDate = '2023-07-12';
    $messages->attachments = '{
            "attachments": [
              "abc.png",
              "def.png",
              "ghi.png"
            ]
          }';
    $messages->save();


  }

}