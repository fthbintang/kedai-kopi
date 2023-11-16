@extends('layout.layout')
@section('content')
<div class="content-body"> 
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/barang-keluar">Barang Keluar</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center mt-10">
                            <h4 class="card-title">{{ $title }}</h4>
                            <button type="button" class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalCreateBarangKeluar"><i class="fa fa-plus"></i> Tambah Data</button>
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Nama Sesi</th>
                                        <th>Pengguna</th>
                                        <th>Waktu Masuk</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangKeluar as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->nama_sesi }}</td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ $row->keterangan ?? 'Tidak ada Keterangan' }}</td>
                                            <td>{{ $row->status }}</td>
                                            <td>
                                                <a href="/dashboard/barang-keluar/list-barang-keluar/{{ $row->id }}" class="btn btn-xs btn-primary" ><i class="fa fa-edit"></i>Details</a>
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
    <div class="modal fade" id="modalCreateBarangKeluar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/barang-keluar">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_sesi">Nama Sesi</label>
                            <input type="text" class="form-control @error('nama_sesi') is-invalid @enderror" name="nama_sesi" id="nama_sesi" placeholder="Nama Sesi..." required>
                            @error('nama_sesi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" placeholder="Keterangan...">
                            <small>Tidak Wajib Diisi.</small>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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

@endsection
