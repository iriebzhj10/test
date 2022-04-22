<?php

namespace App\Models;

use App\Models\User;
use App\Models\Abonnement;
use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;



class Module extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory,HasRoles;
    protected static $logFillable = true;
    protected $guard_name = 'web';

    protected $fillable = [
        'libelle',
        'description',
        'montant',
        'date_debut',
        'date_buttoire',
        'created_user',
        'updated_user',
        'status',
        'entreprise_id',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'modules',
                'field' => 'code',
                'length' => 15,
                'prefix' => 'MO',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function entreprises()
    {
        return $this->belongsToMany(Entreprise::class)->withPivot('duree')->withTimestamps();
    }

    public function abonnements()
    {
        return $this->belongsToMany(Abonnement::class)->withTimestamps();
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
