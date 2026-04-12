<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'profile_photo', 'address',
        'job', 'birth_date', 'phone', 'onboarding_completed', 'saving_mode',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'onboarding_completed' => 'boolean',
    ];

    public function pet()
    {
        return $this->hasOne(UserPet::class);
    }

    public function incomes()
    {
        return $this->hasOne(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function savingHistories()
    {
        return $this->hasMany(SavingHistory::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'user_accessories')
                    ->withPivot('is_equipped', 'acquired_at')
                    ->withTimestamps();
    }
}