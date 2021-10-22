<?php

declare(strict_types=1);

namespace App\Services\Profiling\User;

use App\Models\Profiling\User;
use App\Repository\Profiling\UserRepository;
use ReflectionException;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class UserUpdater {
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UserCreator constructor
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     * @return User
     * @throws ReflectionException
     */
    public function update(User $user): User {
        $this->repository->save($user);

        return $user;
    }
}