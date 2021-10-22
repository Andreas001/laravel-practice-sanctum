<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Models\Post\Post;
use App\Models\Profiling\User;
use Carbon\Carbon;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class PostFactory {
    /**
     * @param array $payload
     * @return Post
     */
    public function create(array $payload): Post {
        $post = new Post();


        if (null !== $poster = User::find($payload['poster'])) {
            $post->user()->associate($poster);
        }

        $post->title = $payload['title'];
        $post->content = $payload['content'];
        $post->created_at = Carbon::now();

        return $post;
    }
}