<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SymptomsHealthProfileMap extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "symptomsAppointmentsMap";
    protected $fillable = ['symptom'];

}