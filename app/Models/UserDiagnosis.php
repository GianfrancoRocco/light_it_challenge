<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDiagnosis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','diagnosis','is_correct'];

    protected $casts = [
        'diagnosis' => 'array',
        'created_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isMarkedAsCorrect(): string
    {
        return $this->is_correct ? 'Yes' : 'No';
    }
}
