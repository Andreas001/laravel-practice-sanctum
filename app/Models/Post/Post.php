<?php

namespace App\Models\Post;

use App\Models\AbstractModel;
use App\Relations\Profiling\User\BelongsToUserTrait;

class Post extends AbstractModel
{
    use BelongsToUserTrait;
    
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];
}
