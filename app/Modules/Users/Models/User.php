<?php

namespace App\Modules\Users\Models;

use App\Core\Database\BaseModel;

final class User extends BaseModel
{
    protected string $table = 'users';

    protected array $fillable = [
        'name', 'email', 'password', 'role'
    ];
}