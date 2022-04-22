<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creancier extends Model
{
    use HasFactory;

    protected static $logFillable = true;
    protected $fillable = [
        'type',
        'nom',
        'slug',
        'contact',
        'email',
        'address',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
    ];
}
