<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }
}
