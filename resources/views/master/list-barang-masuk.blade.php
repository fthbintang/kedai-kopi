@extends('layout.layout')
@section('content')
    <div class="content-body"> 
        <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/dashboard/barang-masuk">Barang Masuk</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/barang-masuk/list-barang-masuk">List Barang Masuk</a></li>
            </ol>
        </div>
    </div>

    <div class="d-flex mr-4">
        <a href="/dashboard/barang-masuk" class="btn btn-danger btn-round ml-auto">Kembali</a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h3>Keterangan: </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            @if (!empty($listBarangMasuk->first()->barangMasuk->keterangan))
                                <p>{{ $listBarangMasuk->first()->barangMasuk->keterangan }}</p>
                            @else
                                <p>Tidak ada Keterangan</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <a href="#modalEditKeterangan{{ $barangMasuk->first()->id }}" data-toggle="modal" class="btn btn-xs btn-primary">
                                <i class="fa fa-edit"></i> Edit Keterangan
                            </a>
                        </div>
                    </div>
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
                            <a href="#" class="btn btn-success btn-round mr-2">ACC</a>
                            <a href="#" class="btn btn-danger btn-round">Tidak ACC</a>
                        </div>
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
                            <button type="button" class="btn btn-primary btn-round ml-2" data-toggle="modal" data-target="#modalCreate"><i class="fa fa-plus"></i> Tambah Data</button>
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
                                        <th>Stok Masuk</th>
                                        <th>Stok Sesudah</th>
                                        <th>Waktu Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listBarangMasuk as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->barang->nama_barang }}</td>
                                            <td>{{ $row->stok_sebelum }}</td>
                                            <td>{{ $row->stok_masuk }}</td>
                                            <td>{{ $row->stok_sesudah }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>
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
    </div> 

@endsection
