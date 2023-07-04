<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalConditionsHealthProfileMap extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "medicalconditionshealthprofilemap";
    protected $fillable = ['medicalCondition'];

}