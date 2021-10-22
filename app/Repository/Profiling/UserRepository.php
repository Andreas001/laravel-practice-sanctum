<?php

declare(strict_types=1);

namespace App\Repository\Profiling;

use App\Models\Profiling\User;
use App\Repository\Repository;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class UserRepository extends Repository {
    /** 
     * @param string|null $keyword
     * @param int $limit
     * @return LengthAwarePaginator
    */
    public function findByName(?string $keyword, int $limit) {
        $query = User::query();

        if($keyword) {
            $query->where('name', 'ilike', '%' . $keyword . '%');
        }

        return $query->paginate($limit);
    }

    /** 
     * @param string $identifier
     * @return Builder|Model|object|null
    */
    public function findOneByUniqueIdentifier(string $identifier) {
        $query = User::query();
        
        $query->where('username', $identifier);
                // ->orWhere('email', $identifier);
        
        return $query->first();
    }

    /** 
     * @param string $email
     * @param string $id
     * @return Builder|Model|object|null
    */
    public function findByEmailAndExclude(string $email, string $id) {
        $query = User::query();

        $query->where('email', "=", $email)
              ->where('id', "!=", $id);
    }

    /** 
     * @param string $username
     * @param string $id
     * @return Builder|Model|object|null
    */
    public function findByusernameAndExclude(string $username, string $id) {
        $query = User::query();

        $query->where('email', "=", $username)
              ->where('id', "!=", $id);
        
        return $query->first();
    }

    // /**
    //  * @param string $activationToken
    //  * @return Builder|Model|object|null
    //  */
    // public function findByActivationToken(string $activationToken) {
    //     $query = User::query();

    //     $query->where('activationToken', "=", $activationToken);

    //     return $query->first();
    // }

    /**
     * @param string $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function find(string $id)
    {
        $query = User::query();

        return $query->find($id);
    }
}