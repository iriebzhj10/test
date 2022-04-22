<?php

namespace App\Models;

use App\Models\User;
use App\Models\Versement;
use App\Models\Entreprise;
use Spatie\MediaLibrary\HasMedia;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Compte extends Model implements HasMedia
{

    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;
    /**
     * Get the  entreprises that owns the Compte
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected $fillable = [
        'numero_compte',
        'libelle',
        'solde',
        'description',
        'entreprise_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
        'delete_update_at'

    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'comptes',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'CO',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

/**
 * Get all of the transferts for the Compte
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function transferts()
{
    return $this->hasMany(Transfert::class);
}

    public function depenses()
    {
        return $this->belongsToMany(Depenses::class)
        ->withPivot('montant_reglement', 'date_reglement', 'note')
        ->withTimestamps();
    }



    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function versements()
    {
        return $this->hasMany(Versement::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class ,'user_created');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class ,'user_updated');
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(368)
        ->height(232)
        ->sharpen(10);

        $this->addMediaConversion('normal')
        ->width(800)
        ->height(600)
        ->sharpen(10);

        $this
        ->addMediaConversion('my-conversion')
        ->greyscale()
        ->quality(80)
        ->withResponsiveImages();
    }
}
