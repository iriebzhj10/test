<?php

namespace App\Models;

use App\Models\Taxe;
use App\Models\User;
use App\Models\Article;
use App\Models\Paiement;
use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Facture extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;

    protected $fillable = [

        'libelle',
        'date_echeance',
        'date_emission',
        'designation',
        'description',
        'quantite',
        'remise',
        'total_ht',
        'total_taxe',
        'total_livraison',
        'remise',
        'total_ttc',
        'taxe_id',
        'devise_id',
        'entreprise_id',
        'user_id',
        'client_id',
        'etat',
        'created_user',
        'update_user',
        'type_facture_id',
        'status',
        'state',
        'transition',

    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'factures',
                'field' => 'code',
                'length' => 12,
                'prefix' => 'FAC',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function echeancier()
    {
        return $this->hasMany(Echeancier::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }


    public function articles()
    {
        return $this->belongsToMany(Article::class,)
        ->withPivot('prix', 'quantite', 'options','prix_vente','qte_un_article','prix_total ')
        ->withTimestamps();
    }

    public function taxes()
    {
        return $this->belongsToMany(Taxe::class);
    }

    public function paiement()
    {
        return $this->belongsToMany(Paiement::class);
    }

    public function versements()
    {
        return $this->hasMany(Versement::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
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
