<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDiagnosis extends Model
{
    use HasFactory;

    protected $table = 'user_diagnosis';

    protected $fillable = ['user_id','selected_symptoms','diagnosis','marked_as_correct'];

    protected $casts = [
        'diagnosis' => 'array',
        'selected_symptoms' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function displayWhenMarkedAsCorrect(): string
    {
        $updatedAt = $this->updated_at;

        return "Marked as correct on {$updatedAt->format('m/d/Y')} at {$updatedAt->format('h:i A')}";
    }
}
