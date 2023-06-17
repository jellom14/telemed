<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function patient() : ?HasMany {
        return $this->hasMany(Patient::class);
    }

    public function staff() : ?HasMany {
        return $this->hasMany(Staff::class);
    }


}
