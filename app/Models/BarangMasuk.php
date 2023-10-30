<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
