@extends('layout.layout')
@section('content')

<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/jadwal-karyawan">Jadwal Karyawan</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h4 class="card-title">{{ $title }}</h4>
                            <button type="button" class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalCreate"><i class="fa fa-plus"></i> Tambah Data</button>
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($jadwal as $row)
                                        <tr>
                                            <td align="center">{{ $no++; }}</td>
                                            <td align="center">{{ $row->user->name }}</td>
                                            @if ($row->waktu_mulai == "Libur" || $row->waktu_selesai == "Libur")
                                                <td colspan="2" align="center">Libur</td>
                                            @else
                                                <td align="center">{{ date("h:i A", strtotime($row->waktu_mulai)) }}</td>
                                                <td align="center">{{ date("h:i A", strtotime($row->waktu_selesai)) }}</td>
                                            @endif
                                            <td align="center">
                                                <a href="#modalEdit{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-primary">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h4 class="text-gray">KETERANGAN WAKTU :</h4>
                                    <p><b>Waktu menggunakan format 24 Jam</b></p>
                                </div>

                                <div class="col-4">
                                    <h4 class="text-gray">KETERANGAN SHIFT :</h4>
                                    <ul>
                                        <li><b>Shift 1</b> : Jam 8 Pagi - Jam 3:30 Sore</li>
                                        <li><b>Shift 2</b> : Jam 3:30 Sore - jam 11 Malam</li>
                                    </ul>
                                </div>
                            </div>
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
                <h5 class="modal-title">Tambah Data Jadwal Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/jadwal-karyawan">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="user_id">Pilih Karyawan</label>
                            <select class="form-control" name="create_user_id" id="user_id" required>
                                <option value="" hidden>-- Pilih Karyawan --</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            
                            </select>
                            @error('create_user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shift">Pilih Shift</label>
                        <select class="form-control" name="create_shift" id="shift" required>
                            <option value="" selected>-- Pilih --</option>
                            <option value="shift-1">08:00 Pagi - 03:30 Sore</option>
                            <option value="shift-2">03:30 Sore - 11:00 Malam</option>
                            <option value="libur">Libur</option>
                        </select>
                        @error('create_shift')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Kembali</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
@foreach ($jadwal as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Jadwal Karyawan {{ $item->user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/jadwal-karyawan/{{ $item->id }}">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Karyawan</label>
                        <input type="text" class="form-control" name="edit_name" id="name" readonly placeholder="Nama Lengkap..." value="{{ $item->user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="shift">Pilih Shift</label>
                        <select class="form-control" name="edit_shift" id="shift" required>
                            <option value="shift-1" {{ ($item->waktu_mulai == "08:00:00") ? "selected" : '' }}>08:00 Pagi - 03:30 Sore</option>
                            <option value="shift-2" {{ ($item->waktu_mulai == "15:30:00") ? "selected" : '' }}>03:30 Sore - 11:00 Malam</option>
                            <option value="libur" {{ ($item->waktu_mulai == "Libur") ? "selected" : '' }}>Libur</option>
                        </select>
                        @error('edit_shift')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Kembali</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Modal Delete --}}
@foreach ($jadwal as $item)
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Jadwal Karyawan {{ $item->user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>                

            <form method="POST" action="/dashboard/jadwal-karyawan/{{ $item->id }}">
                @method('delete')
                @csrf
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