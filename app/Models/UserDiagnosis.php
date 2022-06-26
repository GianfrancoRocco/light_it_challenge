<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDiagnosis extends Model
{
    use HasFactory;

    protected $table = 'user_diagnosis';

    protected $fillable = ['user_id','diagnosis','marked_as_correct'];

    protected $casts = [
        'diagnosis' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
