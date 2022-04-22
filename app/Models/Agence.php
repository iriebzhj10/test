<?php

namespace App\Models;

use App\Models\User;
use App\Models\Projet;
use App\Models\Entreprise;
use App\Models\Inventaire;
use App\Models\Localisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Agence extends Model implements HasMedia
{
    use Sluggable, InteractsWithMedia, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [
        'matricule',
        'libelle',
        'slug',
        'contact',
        'email',
        'longitude',
        'latitude',
        'description',
        'adresse',
        'localisation',
        'pays_id',
        'ville_id',
        'entreprise_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'libelle'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'agences',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'AG',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function localisations()
    {
        return $this->belongsTo(Localisation::class, 'pays_id', 'ville_id');
    }


    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class);
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function pays()
    {
        return $this->belongsTo(Localisation::class);
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
