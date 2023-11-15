<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gaji extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'gaji',
        'date',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
