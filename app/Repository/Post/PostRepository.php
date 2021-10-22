<?php

declare(strict_types=1);

namespace App\Repository\Post;

use App\Models\Post\Post as Post;
use App\Repository\Repository;

/**
 * @author andreasgeraldo0@gmail.com
 */
final class PostRepository extends Repository {
    /** 
     * @param string|null $keyword
     * @param int $limit
     * @return LengthAwarePaginator
    */
    public function findByTitle(?string $keyword, int $limit) {
        $query = Post::query();

        if($keyword) {
            $query->where('title', 'ilike', '%' . $keyword . '%');
        }

        return $query->paginate($limit);
    }

    /**
     * @param string $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function find(string $id)
    {
        $query = Post::query();

        return $query->find($id);
    }
}