<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agence;
use App\Models\Article;
use App\Models\Entreprise;
use App\Models\Departement;
use Spatie\MediaLibrary\HasMedia;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Inventaire extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;


    protected $fillable = [
        'libelle',
        'description',
        'agence_id',
        'entreprise_id',
        'departement_id',
        'user_id',
        'article_restant',
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
                'table' => 'inventaires',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'INV',
                'reset_on_prefix_change' => false,
            ]);
        });
    }


    public function articles()
    {
    return $this->belongsToMany(Article::class)->withPivot(['article_restant'])->withTimestamps();
    }



    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function departements()
    {
        return $this->belongsTo(Departement::class);
    }

    public function user()
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
