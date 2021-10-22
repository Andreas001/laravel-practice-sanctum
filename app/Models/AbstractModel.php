<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use RuntimeException;
use Illuminate\Database\Eloquent\Model;

/**
 * @author andreasgeraldo0@gmail.com
 */
class AbstractModel extends Model
{
    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @incrementing bool
     */
    public $incrementing = false;

    /**
     * BOOT MODEL
     */
    protected static function booted() {
        static::creating(function (Model $model) {
            $model->{$model->primaryKey} = uniqid();
        });
    }

    /**
     * @param array $options
     * @return bool|void
     */
    public function save(array $options = []) {
        throw new RuntimeException("Use Repository to save model");
    }

    /**
     * @param array $options
     * @return bool|void
     */
    public function delete(array $options = []) {
        throw new RuntimeException("Use Repository to delete model");
    }

    /**
     * @param array $options
     */
    protected function persist(array $options = [])
    {
        parent::save($options);
    }

    /**
     * @param array $options
     * @throws Exception
     */
    protected function remove(array $options = [])
    {
        parent::delete($options);
    }
}
