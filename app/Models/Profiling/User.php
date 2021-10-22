<?php

namespace App\Models\Profiling;

use App\Models\AbstractModel;
use App\Relations\Post\HasManyPostsTrait;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends AbstractModel
{
    use HasManyPostsTrait;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'created_at',
        'department_at',
    ];

    /**
     * The attributes that should be hidden for arrays
     * 
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value): void {
        $this->attributes['password'] = Hash::make($value);
    }
}
