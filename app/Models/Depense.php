<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agence;
use App\Models\Parametre;
use App\Models\Entreprise;
use App\Models\Departement;
use App\Models\SousDepense;
use Spatie\MediaLibrary\HasMedia;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Depense extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;


    protected $fillable = [
        'libelle',
        'description',
        'montant_depense',
        'fournisseur',
        'type_depense',
        'date_recurrente',
        'facture_fournisseur',
        'date_emission',
        'type_depense_id',
        'entreprise_id',
        'agence_id',
        'projet_id',
        'employe_id',
        'departement_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
        'status_depense',
        'projet',
        'agence',
        'departement',
        'employe'


    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'depenses',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'DEP',
                'reset_on_prefix_change' => false,
            ]);
        });
    }



/**
 * Get all of the sous_depense for the Depense
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function sous_depenses()
{
    return $this->hasMany(SousDepense::class);
}


    public function comptes()
    {
        return $this->belongsToMany(Compte::class)
        ->withPivot('montant_reglement', 'date_reglement', 'note')
        ->withTimestamps();
    }

    public function parametre()
    {
        return $this->belongsTo(Parametre::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class ,'user_created');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class ,'user_updated');
    }

    public function projets()
    {
        return $this->belongsTo(Projet::class)->withTimestamps();
     }

    //  public function agence()
    //  {
    //      return $this->belongsTo(Agence::class);
    //  }

     public function users()
     {
         return $this->belongsToMany(Users::class)->withTimestamps();
      }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
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
