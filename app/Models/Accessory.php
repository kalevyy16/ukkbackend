<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'icon'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_accessories')
                    ->withPivot('is_equipped', 'acquired_at')
                    ->withTimestamps();
    }
}