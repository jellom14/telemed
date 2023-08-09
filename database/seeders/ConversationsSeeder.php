<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Conversations;

class ConversationsSeeder extends Seeder
{

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('caders')->truncate();

    $conversations = new Conversations;
    $conversations->fromUserId = 9;
    $conversations->toUserId = 6;
    $conversations->save();

    $conversations = new Conversations;
    $conversations->fromUserId = 9;
    $conversations->toUserId = 8;
    $conversations->save();

    $conversations = new Conversations;
    $conversations->fromUserId = 5;
    $conversations->toUserId = 8;
    $conversations->save();

  }

}