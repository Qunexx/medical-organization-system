<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends \Orchid\Platform\Models\Role
{
    use HasFactory;

    /**
     * Получить enum
     */
    public function getEnum(): RoleEnum
    {
        return RoleEnum::from($this->slug);
    }
}
