<?php

namespace App\Models;

use App\Models\User;
use App\Models\Depense;
use App\Models\Commande;
use App\Models\Prospection;
use App\Models\TypeParametre;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Parametre extends Model implements HasMedia

{
    use Sluggable,InteractsWithMedia,SoftDeletes,LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [
        'libelle',
        'slug',
        'icone',
        'description',
        'type_parametre_id',
        'entreprise_id',
        'created_user',
        'updated_user',
        'status',
        'parent_id',
        'created_at',
        'updated_at',
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
                'table' => 'parametres',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'PA',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function type_parametre()
    {
        return $this->belongsTo(TypeParametre::class,'type_parametre_id');
    }

    // public function entreprise()
    // {
    //     return $this->belongsTo(Entreprise::class);
    // }


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function article()
    {
        return $this->hasMany(Article::class,'category_id');
    }



    // public function parametres()
    // {
    //     return $this->hasMany(Parametre::class,
    //     'domaine_id', 'type_entreprise_id', 'creancier_id','mode_paiement_id' ,'client_id' ,'type_prevision_id','type_user_id');
    // }



    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function prospections()
    {
        return $this->hasMany(Prospection::class);
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
