<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentaire extends Model
{
    use HasFactory ,SoftDeletes,LogsActivity ;
    protected static $logFillable = true;
//   'code',
    protected $fillable = [
     
        'libelle',
        'created_user',
        'employee_id',
        'client_id',
        'facture_id',
        'created_at',
        'updated_at',
        'entreprise_id',
        'departement_id',
        'commentaire',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     self::creating(function ($model) {
    //         $model->code = IdGenerator::generate([
    //             'table' => 'commentaires',
    //             'field' => 'code',
    //             'length' => 15,
    //             'prefix' => 'COMENT',
    //             'reset_on_prefix_change' => false,
    //         ]);
    //     });
    // }

     public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class,'departement_id');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class ,'created_user');
    }

    public function created_employee_id()
    {
        return $this->belongsTo(User::class ,'employee_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class ,'client_id');
    }


}
