<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalConditionsAppointmentsMap extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "medicalConditionsAppointmentsMap";
    protected $fillable = ['medicalCondition'];

}