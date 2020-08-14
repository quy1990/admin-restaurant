<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = "user_type";

    protected $fillable = ['type_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
