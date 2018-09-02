<?php

namespace App\Models;

use App\Battlenet\Regions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Model
{
    use Regions, SoftDeletes;

    /**
     * Default properties.
     *
     * @var array
     */
    protected $attributes = [
        'region' => 'eu',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region',
        'realm',
        'name',
    ];

    /**
     * Validates and sets the region attribute.
     *
     * @param  string $value
     * @return void
     */
    public function setRegionAttribute($value)
    {
        if (in_array($value, $this->regions)) {
            $this->attributes['region'] = $value;
        }
    }

    /**
     * Get the user that owns the character.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
