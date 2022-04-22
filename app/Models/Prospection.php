<?php

namespace App\Models;

use App\Models\User;
use App\Models\Parametre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Prospection extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity,HasFactory;
    protected static $logFillable = true;

    protected $fillable = [
        'employe_id',
        'libelle',
        'description',
        'date_debut',
        'date_fin',
        'entreprise_id',
        'created_user',
        'updated_user',
        'status',
        'created_at',
        'updated_at'
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'prospections',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'PRS',
                'reset_on_prefix_change' => false,
            ]);
        });
    }
  
   
    // public function users()
    // {
    //     return $this->hasMany(User::class, 'prospection_id', 'user_id');
    // }




    public function users()
    {
        return $this->belongsTo(Parametre::class, 'employé_id');
        
        return $this->hasMany(User::class, 'prospection_id', 'user_id');

        return $this->belongsToMany(User::class)->withTimestamps();

    }


    public function prospects()
    {

        return $this->belongsToMany(User::class)->withPivot('user_id','prospection_id','created_at','updated_at')->withTimestamps();

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
