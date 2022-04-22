<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agence;
use App\Models\Compte;
use App\Models\Module;
use App\Models\Projet;
use App\Models\Prevision;
use App\Models\Abonnement;
use App\Models\Inventaire;
use App\Models\Patrimoine;
use App\Models\Departement;
use App\Models\EntrepriseInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Entreprise extends Model implements HasMedia
{
    use Sluggable, InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;

    protected $fillable = [
        'immatricule',
        'slug',
        'libelle',
        'description',
        'username',
        'ville',
        'contact',
        'fixe',
        'adresse',
        'boite_postale',
        'taille_id',
        'devise_id',
        'pays_id',
        'indicateur',
        'localisation',
        'pays',
        'ville_id',
        'nombre_employe',
        'nombre_agence',
        'domaine_id',
        'type_entreprise_id',
        'email',
        'site_internet',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'localisation' =>'array'
    ];

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
                'table' => 'entreprises',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'EN',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }

    // public function parametres()
    // {
    //     return $this->hasMany(Parametre::class);
    // }

    /**
     * Get all of the comments for the Entreprise
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transferts()
    {
        return $this->hasMany(transfert::class);
    }

    public function remboursements()
    {
        return $this->hasMany(Remboursement::class);
    }

    public function articles()
    {
        return $this->hasMany(Articles::class);
    }

    public function agences()
    {
        return $this->hasMany(Agence::class);
    }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    public function entreprise_infos()
    {
    return $this->hasMany(EntrepriseInfo::class);
    }

    public function modules()
    {
    return $this->belongsToMany(Module::class)->withPivot(['duree'])->withTimestamps();
    }

    public function abonnements()
    {
        return $this->belongsToMany(Abonnement::class)->withPivot(['duree'])->withTimestamps();
    }

    public function inventaires()
    {
        return $this->hasMany(Inventaire::class);
    }

    public function patrimoine()
    {
        return $this->hasMany(Patrimoine::class);
    }

    public function previsions()
    {
        return $this->hasMany(Prevision::class);
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


   public function users()
   {
       return $this->belongsToMany(User::class)->withTimestamps();
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
        ->quality(80)
        ->withResponsiveImages();
    }
}

