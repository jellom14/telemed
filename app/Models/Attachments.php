<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['fromUserId', 'toUserId', 'filePathOnServer', 'sentDate', 'readDate',];
}
