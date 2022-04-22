<?php

namespace App\Models;

use App\Models\User;
use App\Models\Facture;
use App\Models\Parametre;
use App\Models\Promotion;
use App\Models\Inventaire;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use Sluggable, InteractsWithMedia, SoftDeletes, LogsActivity;
    protected static $logFillable = true;
    protected $fillable = [
        'matricule',
        'libelle',
        'type',
        'slug',
        'description',
        'prix_achat',
        'prix_vente',
        'poids',
        'lien_video',
        'type_article_id',
        'entreprise_id',
        'category_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at',
        'delete_update_at'
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
                'table' => 'articles',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'AR',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function inventaires()
    {
    return $this->belongsToMany(Inventaire::class)->withPivot(['article_restant'])->withTimestamps();
    }


    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function parametre()
    {
        return $this->belongsTo(Parametre::class,'category_id','id');
    }
    
    public function factures()
    {
        return $this->belongsToMany(Facture::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
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
