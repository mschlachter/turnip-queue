<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurnipQueueMessage extends Model
{
    use SoftDeletes;
    
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
