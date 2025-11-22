<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurnipSeeker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'turnip_queue_id',
        'reddit_username',
        'in_game_username',
        'island_name',
        'custom_answer',
        'token',
        'joined_queue',
        'received_code',
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
        'received_code' => 'datetime',
        'last_ping' => 'datetime',
        'left_queue' => 'boolean',
    ];

    public function scopeInQueue($query)
    {
        return $query->where('left_queue', false);
    }

    public function turnipQueue()
    {
        return $this->belongsTo(TurnipQueue::class);
    }

    public function getIsActive()
    {
        return $this->last_ping?->greaterThan(now()->subSeconds(20));
    }
}
