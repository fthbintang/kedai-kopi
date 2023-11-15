@extends('layout.layout')
@section('content')
<div class="content-body"> 
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            </ol>
        </div>
    </div>

    @if (Auth::user()->jadwal || Auth::user()->level != 3)
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center mb-4">
                                @if (auth()->user()->foto)
                                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" height="80" width="80" alt="">
                                @else
                                    <img src="/assets/images/avatar/3.png" height="80" width="80" alt="">
                                @endif
                                <div class="media-body ml-3">
                                    <h3 class="mb-0">{{ Auth()->user()->name }}</h3>
                                    @if (Auth()->user()->level == 1)
                                        <span class="badge badge-pill badge-danger">Admin</span>
                                    @elseif (Auth()->user()->level == 2)
                                        <span class="badge badge-pill badge-primary">Owner</span>
                                    @else
                                        <span class="badge badge-pill badge-success text-white">Pekerja</span>
                                    @endif    
                                </div>
                            </div>
                            @if (Auth::user()->level != 3)
                                <h5>Selamat Datang, {{ Auth::user()->name }}  !</h5>
                                <p class="text-muted">
                                    Saat ini, terdapat {{ $jumlah_barang_masuk }} barang masuk dan {{ $jumlah_barang_keluar }} barang keluar yang belum di approve. Silahkan klik tombol disamping untuk menuju kehalaman.
                                </p>
                            @else

                                <p>Jadwal Kehadiran : {{ Auth::user()->jadwal->waktu_mulai }} - {{ Auth::user()->jadwal->waktu_selesai }}</p>

                                <div class="row"> 
                                    @if (Auth::user()->isCheckedInToday())
                                        <a href="#modalCheckout{{ auth()->user()->id }}" data-toggle="modal" class="btn btn-danger col-12">
                                            <i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check Out !
                                        </a>
                                    @else
                                        @if (auth::user()->ScheduleChecker() && !auth::user()->isCheckedOutToday())
                                            <a href="#modalCheckin{{ auth()->user()->id }}" data-toggle="modal" class="btn btn-success text-white col-12">
                                                <i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check In !
                                            </a>
                                        @else
                                            <a href="#modalCheckin{{ auth()->user()->id }}" data-toggle="modal" class="btn btn-success text-white col-12 disabled">
                                                <i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check In !
                                            </a>
                                        @endif
                                        
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>  
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Barang Masuk (Unapprove)</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $jumlah_barang_masuk }}</h2>
                                @if (Auth::user()->level != 3)
                                <p class="text-white mb-0">
                                    <a href="/dashboard/barang-masuk" class="btn gradient-2 border-0 btn-rounded">
                                        <i class="fa-solid fa-box"></i> Approve Sekarang
                                    </a>
                                </p>
                                @endif
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa-solid fa-box"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">Barang Keluar (Unapprove)</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $jumlah_barang_keluar }}</h2>
                                @if (Auth::user()->level != 3)
                                <p class="text-white mb-0">
                                    <a href="/dashboard/barang-keluar" class="btn gradient-3 border-0 btn-rounded">
                                        <i class="fa-solid fa-box"></i> Approve Sekarang
                                    </a>
                                </p>
                                @endif
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa-solid fa-box"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->level == 3)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rekap Presensi Bulan Ini.</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr align="center">
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Waktu Check In</th>
                                                <th>Waktu Check Out</th>
                                                <th>Tanggal Tec</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kehadiran_karyawan as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $row->user->name }}</td>
                                                    <td>{{ $row->waktu_masuk }}</td>
                                                    <td>{{ $row->waktu_keluar }}</td>
                                                    <td>{{ $row->date }}</td>
                                                    <td>
                                                        @if ($row->is_late == 1)
                                                            <span class="badge badge-pill badge-danger">Terlambat</span>
                                                        @else
                                                            <span class="badge badge-pill badge-success text-white">Tepat Waktu</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            @endif
        </div>
    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h1>OOPS !</h1>
                        <h4>Anda Masih Belum Memiliki Jadwal Presensi, Silahkan Hubungi Admin / Owner Untuk <br> 
                            Mendapatkan Jadwal Presensi.</h4>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    @endif

    

    {{-- Modal Presensi Checkin --}}
    <div class="modal fade" id="modalCheckin{{ auth()->user()->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lakukan Check In !</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/presensi/checkin/{{ auth()->user()->id }}">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>Pastikan waktu saat anda melakukan check in kehadiran.
                                <br><br>
                                Toleransi keterlambatan hanya 20 menit dari jadwal shift yang telah dibagikan pada masing-masing karyawan.
                                <br>
                                Apabila waktu check in melewati batas toleransi, maka anda akan tercatat dengan keterangan terlambat.
                            </h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal"><i class="fa fa-undo" style="color: #FFFFFF;""></i> Close</button>
                        <button type="submit" class="btn btn-success text-white"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check In !</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Presensi Checkout --}}
    <div class="modal fade" id="modalCheckout{{ auth()->user()->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lakukan Check In !</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/presensi/checkout/{{ auth()->user()->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>
                                Sebelum melakukan check out, pastikan semua tugas anda hari ini sudah tercatat kedalam sistem.
                                <br><br>
                                Setelah anda melakukan check out, maka anda tidak dapat masuk kedalam sistem hingga masuk jadwal shift anda berikutnya.
                            </h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check Out !</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection