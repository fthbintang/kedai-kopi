<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListBarangMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function BarangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class);
    }

    public function Barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
