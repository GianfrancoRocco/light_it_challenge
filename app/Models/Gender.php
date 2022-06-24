<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public $timestamps = false;

    public function capitalizedDescription(): string
    {
        return ucwords($this->description);
    }
}
