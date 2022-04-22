<?php

namespace App\Models;

use App\Models\Agence;
use App\Models\Activite;
use App\Models\Entreprise;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Projet extends Model implements HasMedia
{

    use InteractsWithMedia,SoftDeletes,LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [
        'libelle',
        'description',
        'budget',
        'date_debut',
        'date_fin',
        'agence_id',
        'entreprise_id',
        'departement_id',
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
                'table' => 'projets',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'PRJ',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function activites()
    {
        return $this->hasMany(Activite::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function depenses()
    {
        return $this->belongsToMany(Depense::class)->withTimestamps();
     }

    public function created_user()
    {
        return $this->belongsTo(User::class,'user_created');
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
