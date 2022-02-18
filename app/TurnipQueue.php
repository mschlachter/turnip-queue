<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurnipQueue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'token',
        'dodo_code',
        'expires_at',
        'concurrent_visitors',
        'custom_question',
        'ask_reddit_username',
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

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }
}
