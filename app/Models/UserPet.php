<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'coin', 'streak', 'level', 'current_exp', 'total_exp', 'last_save_date'];

    protected $casts = [
        'last_save_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}