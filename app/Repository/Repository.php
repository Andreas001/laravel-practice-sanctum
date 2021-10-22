<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\AbstractModel;
use ReflectionException;
use ReflectionMethod;

/**
 * @author andreasgeraldo0@gmail.com
*/
abstract class Repository {
    /** 
     * @param AbstractModel $model
     * @throws ReflectionException
    */
    public function save(AbstractModel $model): void { 
        $method = new ReflectionMethod(get_class($model), 'persist');
        $method->setAccessible(true);

        $method->invoke($model);
    }

    public function delete(AbstractModel $model):void {
        $method = new ReflectionMethod(get_class($model), 'remove');
        $method->setaccessible(true);

        $method->invoke($model);
    }
}