<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';

    public const role_admin = 1;
    public const role_user  =2;
}
