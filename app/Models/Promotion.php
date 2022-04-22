<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Promotion extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity;
    protected static $logFillable = true;
    // use HasFactory;
    protected $fillable = [
        'slug',
        'libelle',
        'description',
        'valeur',
        'validite',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'promotions',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'PR',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class)->withTimestamps();
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
        ->greyscale()
        ->quality(80)
        ->withResponsiveImages();
    }
}
