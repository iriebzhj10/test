<?php

namespace App\Models;

use App\Models\Echange;
use App\Models\Parametre;
use App\Models\Inventaire;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class User extends Authenticatable implements HasMedia
{

    use Sluggable, HasRoles, InteractsWithMedia, SoftDeletes, LogsActivity,HasApiTokens,HasFactory,HasProfilePhoto,HasTeams,Notifiable,TwoFactorAuthenticatable,Notifiable;
    protected static $logFillable = true;
    protected $guard_name = 'web';





    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenoms',
        'slug',
        'contact',
        'numero_fixe',
        'ville',
        'profession',
        'type_client',
        'indicateur',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'date_embauche',
        'adresse_ip',
        'IdCompte',
        'provider',
        'poste',
        'provider_id',
        'creancier_id',
        'username',
        'status_user',
        'email',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'email_verified_at',
        'type_appareil_id',
        'type_user',
        'type_user_creancier',
        'localisation',
        'pays_id',
        'salaire',
        'mode_paiemment',
        'n_assurance',
        'contact_1',
        'contact_2',
        'relation',
        'etat',
        'localisation_urgence',
        'nom_urgence',
        'prenom_urgence',
        'full_name_urgence',
        'client_id',
        'prospection_id',
        'prospection_name',
        'entreprise_id',
        'created_user',
        'updated_user',
        'status',
        'remember_token',
        'current_team_id',
        'profile_photo_path',
        'created_at',
        'updated_at',
        'nombre_enfant',
        'situation_matrimoniale',
        'delete_update_at'

    ];



    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' =>  ['nom', 'prenoms']
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'users',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'US',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    /**
     * Gestion des relations
     *
     */

/**
 * Get all of the transferts for the User
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function transferts()
{
    return $this->hasMany(Transfert::class);
}


    public function parametres()
    {
        return $this->belongsTo(Parametre::class, 'type_appareil_id', 'parametres_id');
    }

    public function prospection()
    {
        return $this->belongsTo(Prospection::class);
    }

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class);
    }

    public function echanges()
    {
        return $this->hasMany(Echange::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function user_infos()
    {
        return $this->hasMany(UserInfo::class);
    }


    public function promotions()
    {
        return $this->belongsToMany(promotion::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entreprise_infos()
    {
        return $this->hasMany(EntrepriseInfo::class);
    }

    public function entreprises()
    {
        return $this->belongsToMany(Entreprise::class)->withTimestamps();
     }

     public function depenses()
     {
         return $this->belongsToMany(Depense::class)->withTimestamps();
      }

      public function departements()
      {
          return $this->belongsToMany(Departement::class)->withTimestamps();
       }


    public function type_parametres()
    {
        return $this->hasMany(TypeParametre::class);
    }

     public function abonnements()
     {
         return $this->hasMany(Abonnement::class);
     }

     public function activites()
     {
         return $this->hasMany(Activite::class);
     }

     public function agences()
     {
         return $this->hasMany(Agence::class);
     }

     public function commandes()
     {
         return $this->hasMany(Commande::class);
     }

     public function comptes()
     {
         return $this->hasMany(Compte::class);
     }

    //  public function departements()
    //  {
    //      return $this->hasMany(Departement::class);
    //  }

    //  public function depenses()
    //  {
    //      return $this->hasMany(Depense::class);
    //  }

     public function emprunts()
     {
         return $this->hasMany(Emprunt::class);
     }

     public function factures()
     {
         return $this->hasMany(Facture::class);
     }

     public function localisations()
     {
         return $this->hasMany(Localisation::class);
     }

     public function modules()
     {
         return $this->hasMany(Module::class);
     }

     public function paiements()
     {
         return $this->hasMany(Paiement::class);
     }

     public function patrimoines()
     {
         return $this->hasMany(Patrimoine::class);
     }

     public function previsions()
     {
         return $this->hasMany(Prevision::class);
     }

     public function articles()
     {
         return $this->hasMany(Article::class);
     }

     public function projets()
     {
         return $this->hasMany(Projet::class);
     }

     public function prospections()
     {
         return $this->belongsToMany(Prospection::class)->withPivot('user_id', 'prospection_id','created_at','updated_at')->withTimestamps();
        //  return $this->hasMany(Prospection::class);


     }

     public function taxes()
     {
         return $this->hasMany(Taxe::class);
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






    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'localisation'=>'array',

    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
