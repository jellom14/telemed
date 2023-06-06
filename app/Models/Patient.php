<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'address', 'birthdate', 'gender', 
    'phone', 'blood_type', 'email', 'username', 'password'];

public function role() : ?BelongsTo{
return $this->belongsTo(Role::class,'role_id');
}       

}
