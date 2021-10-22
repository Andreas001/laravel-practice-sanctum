<?php

declare(strict_types=1);

namespace App\Services\Profiling\User;

use App\Models\Profiling\User;
use App\Repository\Profiling\UserRepository;
use App\Services\Profiling\User\UserFactory;
use ReflectionException;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class UserCreator {
    /**
     * @var UserFactory
     */
    private $factory;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UserCreator constructor
     * @param UserFactory $factory
     * @param UserRepository $repository
     */
    public function __construct(UserFactory $factory, UserRepository $repository) {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @param array $payload
     * @return User
     * @throws ReflectionException
     */
    public function create(array $payload): User {
        $user = $this->factory->create($payload);

        $this->repository->save($user);

        return $user;
    }
}