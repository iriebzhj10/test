<?php

namespace App\Models;


use App\Models\User;
use App\Models\Compte;
use App\Models\Facture;
//use App\Models\Versement;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
// use Haruncpi\LaravelIdGenerator\IdGenerator;

class Versement extends Model implements HasMedia
{
    use InteractsWithMedia,SoftDeletes,LogsActivity,HasFactory;
    protected static $logFillable = true;

    protected $fillable = [
        'montant',
        'entreprise_id',
        'echeancier_id',
        'facture_id',
        'compte_id',
        'user_id',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',
        'status',

    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'versements',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'VS',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function factures()
    {
        return $this->belongsTo(Facture::class,'facture_id');
    }

    public function comptes()
    {
        return $this->belongsTo(Compte::class);
    }

    public function created_user()
    {
        return $this->belongsTo(User::class,'user_created');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
    // use HasFactory,IdGenerator;
    // protected static $logFillable = true;

    // protected $fillable = [
    //     'facture_id',
    //     'moyen_paiement_id ',
    //     'created_user',
    //     'user_id',
    //     'updated_user',
    //     'status',
    //     'created_at',
    //     'updated_at',
    //     'entreprise_id',
    // ];
}
