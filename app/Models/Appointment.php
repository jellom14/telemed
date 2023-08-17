<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lengthOfFeeling',
        'allergicToDrugsComplaint',
        'medicalConditionComplaint',
        'surgeryComplaint',
        'pwdNumber',
        'doctorId',
        'patientId',
        'caderId',
        'dateOfAppointment',
        'timeOfAppointment',
        'complaint',
        'pwdIdNumber',
        'paymentReferenceNumber',
        'pwdIdExpirationDate'
    ];
}