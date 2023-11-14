<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamp = false;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }
}
