<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnipSeeker extends Model
{
    protected $fillable = [
        'turnip_queue_id',
        'reddit_username',
        'in_game_username',
        'island_name',
        'custom_answer',
        'token',
        'joined_queue',
        'last_ping',
        'left_queue',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'joined_queue' => 'datetime',
        'left_queue' => 'boolean',
    ];

    public function scopeInQueue($query)
    {
    	return $query->where('left_queue', false);
    }

    public function turnipSeeker()
    {
        return $this->belongsTo(TurnipQueue::class);
    }
}
