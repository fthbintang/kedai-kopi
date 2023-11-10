<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListBarangKeluar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function BarangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class);
    }

    public function Barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
