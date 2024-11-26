<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtimes extends Model
{
    use HasFactory;

    protected $table = 'overtimes'; // Especificar el nombre correcto de la tabla

    protected $fillable = [
        'FK_BOSS', 'EMPLOYEE_LIST', 'DATE'
    ];

    // El ID se incrementa automáticamente
    public $incrementing = true;
}
