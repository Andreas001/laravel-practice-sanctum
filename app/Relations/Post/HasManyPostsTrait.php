<?php

declare(strict_types=1);

namespace App\Relations\Post;

use App\Models\AbstractModel;
use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @mixin AbstractModel
 * @property Collection|Post[] $user
 *
 * @author andreasgeraldo0@gmail.com
 */
trait HasManyPostsTrait
{
    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
