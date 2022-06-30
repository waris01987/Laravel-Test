<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	/**
     * Get workshops for the event.
     */
	public function workshops() {
        return $this->hasMany(Workshop::class);
    }
}
