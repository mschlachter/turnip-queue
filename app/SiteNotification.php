<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteNotification extends Model
{
    use SoftDeletes;

    const TYPE_SUCCESS = 'success';

    const TYPE_WARNING = 'warning';

    const TYPE_DANGER = 'danger';

    const TYPE_INFO = 'info';

    protected $fillable = [
        'type',
        'message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($builder)
    {
        return $builder->where('is_active', true);
    }
}
