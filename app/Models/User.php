<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'level',
        'status',
        'foto-profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Function Section
    public function isAdmin()
    {
        return $this->level == 1;
    }

    public function isOwner()
    {
        return $this->level == 2;
    }

    public function isPekerja()
    {
        return $this->level == 3;
    }

    public function isCheckedInToday()
    {
        $todaysDate = Carbon::now('GMT+8')->format('Y-m-d');
        $checkedInToday = Presensi::where('user_id', $this->id)
            ->where('date', $todaysDate)
            ->where('waktu_keluar', null)->first();

        if ($checkedInToday)
            return 1;
        else
            return 0;
    }

    public function isCheckedOutToday()
    {
        $todaysDate = Carbon::now('GMT+8')->format('Y-m-d');
        $checkedOutToday = Presensi::where('user_id', $this->id)
            ->where('date', $todaysDate)
            ->whereNotNull('waktu_keluar')->first();

        if ($checkedOutToday)
            return 1;
        else
            return 0;
    }

    function ScheduleChecker()
    {
        $thisTime = Carbon::now('GMT+8')->format('H:i:s');
        $waktuMulai = $this->jadwal->waktu_mulai;
        $waktuSelesai = $this->jadwal->waktu_selesai;

        if ($thisTime >= $waktuMulai && $thisTime <= $waktuSelesai) {
            return 1;
        } else if ($waktuMulai == "Libur" || $waktuSelesai == "Libur") {
            return 0;
        } else {
            return 0;
        }
    }

    // Relation Section
    public function BarangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    public function BarangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function Jadwal(): HasOne
    {
        return $this->hasOne(Jadwal::class);
    }

    public function Presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    public function Gaji(): HasMany
    {
        return $this->hasMany(Gaji::class);
    }
}
