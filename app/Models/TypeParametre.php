<?php

namespace App\Models;

use App\Models\User;
use App\Models\Parametre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class TypeParametre extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity, HasFactory;
    protected static $logfillable = true;

    protected $fillable = [
        'libelle',
        'icone',
        'description',
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
                'table' => 'type_parametres',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'TP',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function parametre()
    {
        return $this->hasMany(Parametre::class);
    }

    public function domaines()
    {
        return $this->hasMany(Domaine::class);
    }


    public function type_entreprises()
    {
        return $this->hasMany(Parametre::class);
    }

    public function mode_paiements()
    {
        return $this->hasMany(Parametre::class);
    }

    public function creanciers()
    {
        return $this->hasMany(Parametre::class);
    }

    public function clients()
    {
        return $this->hasMany(Parametre::class);
    }

    public function previsions()
    {
        return $this->hasMany(Parametre::class);
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
