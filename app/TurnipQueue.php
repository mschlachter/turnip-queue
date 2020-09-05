<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnipQueue extends Model
{
    protected $fillable = [
	    'user_id',
		'token',
		'dodo_code',
		'expires_at',
		'concurrent_visitors',
		'custom_question',
		'is_open',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'is_open' => 'boolean',
    ];

	public function turnipSeekers()
	{
		return $this->hasMany(TurnipSeeker::class);
	}

    public function turnipQueueMessages()
    {
        return $this->hasMany(TurnipQueueMessage::class);
    }

    public function scopeOpen($query) {
    	return $query->where('is_open', true);
    }
}
