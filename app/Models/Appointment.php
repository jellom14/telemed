<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'patient_id', 'staff_id', 'service_id', 'mode_id', 'date', 'note', 
                           'Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9','Q10'];
}
