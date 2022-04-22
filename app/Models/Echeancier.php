<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Echeancier extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'montant',
        'date_echeance',
        'facture_id',
    

    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     self::creating(function ($model) {
    //         $model->code = IdGenerator::generate([
    //             'table' => 'echeanciers',
    //             'field' => 'code',
    //             'length' => 15,
    //             'prefix' => 'ECH',
    //             'reset_on_prefix_change' => false,
    //         ]);
    //     });
    // }

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

   



}
