<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Remboursement extends Model
{
    use HasFactory;

   // use InteractsWithMedia,SoftDeletes,LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [
        'code',
        'slug',
        'libelle',
        'description',
        'montant_remboursement',
        'montant_verse',
        'date_remboursement',
        'emprunt_id',
        'entreprise_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'remboursements',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'VSM',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function emprunt()
    {
        return $this->belongsTo(Emprunt::class);
    }







}
