<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
