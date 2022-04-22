<?php

namespace App\Models;

use App\Models\Depense;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SousDepense extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes, LogsActivity, HasFactory;
    protected static $logFillable = true;

    protected $fillable=[
            'article',
            'prix',
            'quantite',
            'depense_id',
            'created_at',
            'updated_at',
    ];

    /**
     * The roles that belong to the SousDepense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function depense()
    {
        return $this->belongsTo(Depense::class);
    }
}
