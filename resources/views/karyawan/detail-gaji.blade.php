@extends('layout.layout')

@section('content')
<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/gaji-karyawan">Gaji Karyawan</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/gaji-karyawan/{{ $pekerja->id }}">Detail Gaji Karyawan</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center mb-4">
                            @if ($pekerja->foto)
                                <img src="{{ asset('storage/' . $pekerja->foto) }}" height="80" width="80" alt="">
                            @else
                                <img src="/assets/images/avatar/3.png" height="80" width="80" alt="">
                            @endif
                            <div class="media-body ml-3">
                                <h3 class="mb-0">{{ $pekerja->name }}</h3>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col">
                                <div class="card card-profile text-center">
                                    <p class="text-muted px-4">Aktif Sejak :</p>
                                    <p>{{ $pekerja->created_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-profile text-center">
                                    <p class="text-muted px-4">Status :</p>
                                    <p>{{ $pekerja->status }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <button type="button" class="btn btn-primary btn-round col-12" data-toggle="modal" data-target="#modalCreate"><i class="fa fa-money"></i> Bayar Gaji</button>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Gaji Dibayar</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($gaji as $row)
                                        <tr align="center">
                                            <td>{{ $no++; }}</td>
                                            <td>Rp. {{ number_format($row->gaji, 2) }}</td>
                                            <td>{{ $row->date }}</td>
                                            <td>
                                                <a href="#modalDelete{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
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
    </div>
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bayar Gaji {{ $pekerja->name }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/gaji-karyawan">
                @csrf
                <input type="hidden" name="create_user_id" value="{{ $pekerja->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="gaji">Jumlah Gaji</label>
                        <input type="number" class="form-control" name="create_gaji" id="gaji" placeholder="Isikan Jumlah Uang..." required>
                        @error('create_gaji')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="text" class="form-control" name="create_tanggal" id="tanggal" value="{{ now()->format('Y-m-d') }}" required readonly>
                        @error('create_tanggal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Delete --}}
@foreach ($gaji as $item)
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>                

            <form method="POST" action="/dashboard/gaji-karyawan/{{ $item->id }}">
                @method('delete')
                @csrf
                <input type="hidden" name="user_id" value="{{ $pekerja->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <h5>Apakah Anda Ingin Menghapus Data Ini ?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection