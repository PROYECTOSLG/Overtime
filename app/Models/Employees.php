<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'NO_EMPLOYEE', 'AREA', 'NAME', 'PHONE', 'REASON', 'ROUTE', 'DINING', 'SHIFT', 'TIMETABLE', 'NOTES'
    ];

    // El ID se incrementa automáticamente
    public $incrementing = true;
}
