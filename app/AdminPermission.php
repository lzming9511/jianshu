<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends BaseModel
{
    //
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_permission_role', 'role_id', 'permission_id')->withPivot(['permission_id', 'role_id']);
    }
}
