<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nom_permissions extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
    ];
}
