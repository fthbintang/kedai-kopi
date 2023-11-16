@extends('layout.layout')
@section('content')
<div class="content-body"> 
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/pendapatan-harian">Pendapatan Harian</a></li>
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
                            <button type="button" class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalCreate"><i class="fa fa-plus"></i> Tambah Data</button>
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pendapatan</th> 
                                        <td>Keterangan</td>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendapatans as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->tanggal }}</td>
                                            <td>{{ $row->pendapatan }}</td>
                                            <td>{{ $row->keterangan ?? 'Tidak ada Keterangan' }}</td>
                                            <td>
                                                <a href="#modalDelete{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                                        <i class="fa fa-trash"></i> Hapus
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

@endsection
