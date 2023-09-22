<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrugAllergiesAppointmentsMap extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "drugallergiesAppointmentsMap";
    protected $fillable = ['allergyId, healthProfileId'];

}