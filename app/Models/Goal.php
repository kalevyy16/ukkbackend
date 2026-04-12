<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'target_amount', 'collected_amount', 'deadline', 'is_shared', 'completed'];

    protected $casts = [
        'deadline' => 'date',
        'is_shared' => 'boolean',
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingHistories()
    {
        return $this->hasMany(SavingHistory::class);
    }
}