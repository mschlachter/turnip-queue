<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnipQueueMessage extends Model
{
    protected $fillable = [
    	'turnip_queue_id',
		'sent_at',
		'message',
    ];

    protected $casts = [
    	'sent_at' => 'datetime',
    ];

    public function turnipQueue()
    {
        return $this->belongsTo(TurnipQueue::class);
    }
}
