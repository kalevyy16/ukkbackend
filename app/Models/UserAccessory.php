<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccessory extends Model
{
    protected $fillable = ['name', 'description', 'price', 'icon'];
public function users() { return $this->belongsToMany(User::class, 'user_accessories')->withPivot('is_equipped', 'acquired_at'); }
}
