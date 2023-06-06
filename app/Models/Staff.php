<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['role_id', 'first_name', 'last_name', 'address', 'birthdate', 'gender', 
                            'phone', 'email', 'username', 'password'];

    public function role() : ?BelongsTo{
        return $this->belongsTo(Role::class,'role_id');
    }                 

    public function appointment() : ?HasMany {
        return $this->hasMany(Appointment::class);
    }
    
}
