<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\Models\Post\Post;
use App\Repository\Post\PostRepository;
use App\Services\Post\PostFactory;
use ReflectionException;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class PostCreator {
    /**
     * @var PostFactory
     */
    private $factory;

    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * PostCreator constructor
     * @param PostFactory $factory
     * @param PostRepository $repository
     */
    public function __construct(PostFactory $factory, PostRepository $repository) {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @param array $payload
     * @return Post
     * @throws ReflectionException
     */
    public function create(array $payload): Post {
        $post = $this->factory->create($payload);

        $this->repository->save($post);

        return $post;
    }
}