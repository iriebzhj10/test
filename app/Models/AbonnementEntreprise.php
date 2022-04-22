<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class AbonnementEntreprise extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
    protected $table = 'abonnement_entreprise';

    protected $fillable = [
        'code',
        'abonnement_id',
        'entreprise_id',
        'module_id',
        'created_user',
        'updated_user',
        'moyen_paiement',
        'token',
        'montant_ht',
        'montant_tva',
        'montant_remise',
        'montant_ttc',
        'duree',
        'date_final',
        'options',
        'status_paiement',
        'active',
        'nbr_abonnes',
        'nbr_usr_created',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'abonnement_entreprise',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'AE',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
}
