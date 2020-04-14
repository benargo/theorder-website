<?php

namespace App;

use App\KudosReasons;
use Illuminate\Database\Eloquent\Model;

class Kudos extends Model
{
    use KudosReasons;

    /**
     * Get the user who awarded the kudos.
     */
    public function awardedByUser()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user who the Kudos was awarded to.
     */
    public function awardedToUser()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Sets the reason attribute.
     *
     * @param string $value
     */
    public function setReasonAttribute($value)
    {
        if (array_has(self::$reasons, $value)) {
            $this->attributes['reason'] = $value;
        }
    }
}
