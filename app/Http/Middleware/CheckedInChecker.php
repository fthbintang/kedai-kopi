<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckedInChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $todaysDate = Carbon::now('GMT+8')->format('Y-m-d');
        if (auth()->user()->level == 3) {
            // Check if checked in today
            $checkedInToday = Presensi::where('user_id', auth()->user()->id)
                ->where('date', $todaysDate)
                ->where('waktu_keluar', null)->first();

            if ($checkedInToday)
                return $next($request);
            else
                return redirect('/dashboard')->with('error', 'Anda tidak dapat mengakses halaman tersebut.', 'danger');
        }

        return $next($request);
    }
}
