<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transfert extends Model
{
    use SoftDeletes, LogsActivity;
    protected static $logFillable = true;

    protected $fillable = [
        'montant',
        'compte_debiteur',
        'compte_crediteur',
        'created_user',
        'entreprise_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'transferts',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'TRF',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    /**
     * Get the compte that owns the Transfert
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function compte()
    {
        return $this->belongsTo(Compte::class, 'compte_debiteur', 'compte_crediteur');
    }


    /**
     * Get the user that owns the Transfert
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    /**
     * Get the entreprise that owns the Transfert
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }



}
