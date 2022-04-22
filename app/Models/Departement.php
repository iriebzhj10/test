<?php

namespace App\Models;

use App\Models\User;
use App\Models\Projet;
use App\Models\Entreprise;
use App\Models\Inventaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Departement extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;

    protected $fillable = [
        'matricule',
        'libelle',
        'nombre_employe',
        'contact',
        'email',
        'description',
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
                'table' => 'departements',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'DE',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function inventaires()
    {
        return $this->hasMany(Inventaire::class);
    }

    public function commentaire()
    {
        return $this->hasMany(Commentaire::class,'departement_id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class ,'user_created');
    }
    public function depense()
    {
        return $this->belongsToMany(Depense::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(Users::class)->withTimestamps();
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
