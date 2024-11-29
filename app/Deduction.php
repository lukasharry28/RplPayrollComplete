<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Deduction extends Model
{
    use HasSlug;

    protected $primaryKey = 'deduction_id'; // Primary key
    public $incrementing = true; // Pastikan auto-increment aktif
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable = [
        'deduction_id',
        'name',
        'description',
        'amount',
        'slug',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
