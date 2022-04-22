<?php

namespace App\Models;

use App\Models\User;
use App\Models\Compte;
use App\Models\Parametre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Emprunt extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;

    protected $fillable = [
        'libelle',
        'description',
        'montant',
        'taux',
        'delai',
        'date_emprunt',
        'date_remboursement',
        'versements_empr ',
        'creancier_id',
        'compte_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'entreprise_id',
        'updated_at'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'emprunts',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'EM',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function parametre()
    {
        return $this->belongsTo(Parametre::class, 'creancier_id');
    }

    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class,'user_created');
    }

    public function remboursements()
    {
        return $this->hasMany(Remboursement::class);
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class,'user_updated');
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
