<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Models\Post\Post;
use App\Repository\Post\PostRepository;
use ReflectionException;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class PostDeleter {
    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * PostDeleter constructor
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param Post $post
     * @return Post
     * @throws ReflectionException
     */
    public function delete(Post $post): Post {
        $this->repository->delete($post);

        return $post;
    }
}