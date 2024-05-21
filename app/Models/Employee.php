<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'birth_date', 'address', 'photo', 'marital_status'
    ];
}
