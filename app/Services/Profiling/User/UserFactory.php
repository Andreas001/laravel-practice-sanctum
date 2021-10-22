<?php

declare(strict_types=1);

namespace App\Services\Profiling\User;

use App\Models\Profiling\User;
use Carbon\Carbon;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class UserFactory {
    /**
     * @param array $payload
     * @return User
     */
    public function create(array $payload): User {
        $user = new User();

        $user->username = $payload['username'];
        $user->setPasswordAttribute($payload['password']);
        $user->created_at = Carbon::now();

        return $user;
    }
}