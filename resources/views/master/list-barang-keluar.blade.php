@extends('layout.layout')
@section('content')
    <div class="content-body"> 
        <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/barang-keluar">Barang Keluar</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/barang-keluar/list-barang-keluar">List Barang Keluar</a></li>
            </ol>
        </div>
    </div>

    <div class="d-flex mr-4">
        <a href="/dashboard/barang-keluar" class="btn btn-danger btn-round ml-auto">Kembali</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <h3>Nama sesi: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangKeluar->nama_sesi ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <h3>Pengguna: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangKeluar->user->name ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <h3>Waktu input: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangKeluar->created_at ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <h3>Keterangan: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangKeluar->keterangan ?? 'Tidak ada Keterangan' }} </p>
                            </div>
                        </div>
                        @if ($barangKeluar->status != 'ACC')
                            <div class="row">
                                <div class="col-sm">
                                    <a href="#modalEditBarangKeluar{{ $barangKeluar->id }}" data-toggle="modal" class="btn btn-xs btn-primary">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="#modalDeleteBarangKeluar{{ $barangKeluar->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <div class="d-flex align-item-center mt-10">
                                    <h3>Status: </h3>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                @if (!empty($listBarangKeluar->first()->barangKeluar->status))
                                    <p>{{ $listBarangKeluar->first()->barangKeluar->status }}</p>
                                @else
                                    <p>Tidak ada Status</p>
                                @endif
                            </div>
                        </div>
                        @if ($barangKeluar->status != 'ACC')
                            <div class="row">
                                <div class="col-sm">
                                    <a href="#" id="accButton" class="btn btn-success btn-round mr-2">
                                        <i class="fa fa-check"></i> ACC
                                    </a>
                                    <a href="#" id="notAccButton" class="btn btn-danger btn-round">
                                        <i class="fa fa-times"></i> Tidak ACC
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center mt-10">
                            <h4 class="card-title mr-auto">{{ $title }}</h4> 
                            @if ($barangKeluar->status != 'ACC')
                                <button type="button" class="btn btn-primary btn-round ml-2" data-toggle="modal" data-target="#modalCreateListBarangKeluar"><i class="fa fa-plus"></i> Tambah Data</button>
                            @endif
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Sebelum</th> 
                                        <th>Stok Keluar</th>
                                        <th>Stok Sesudah</th>
                                        <th>Waktu Keluar</th>
                                        @if ($barangKeluar->status != 'ACC')
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listBarangKeluar as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->barang->nama_barang }}</td>
                                            <td>{{ $row->stok_sebelum }}</td>
                                            <td>{{ $row->stok_keluar }}</td>
                                            <td>{{ $row->stok_sesudah }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            @if ($barangKeluar->status != 'ACC')
                                                <td>
                                                    <a href="#modalDelete{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            @endif
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

    {{-- Modal Edit Barang Masuk --}}
    <div class="modal fade" id="modalEditBarangKeluar{{ $barangKeluar->id }}" name="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/barang-keluar/{{ $barangKeluar->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_sesi">Nama Sesi</label>
                            <input type="text" class="form-control @error('nama_sesi') is-invalid @enderror" name="nama_sesi" id="nama_sesi" value="{{ $barangKeluar->nama_sesi }}" placeholder="Nama Sesi..." required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" value="{{ $barangKeluar->keterangan }}" placeholder="Opsional">
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
