@extends('layout.layout')
@section('content')

<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/pengguna">Pengguna</a></li>
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
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data_pengguna as $row)
                                        <tr>
                                            <td>{{ $no++; }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->username }}</td>
                                            <td align="center">
                                                <h4>
                                                    @if ($row->level == 'admin')
                                                        <span class="badge badge-pill badge-danger">Admin</span>
                                                    @elseif ($row->level == 'owner')
                                                        <span class="badge badge-pill badge-primary">Owner</span>
                                                    @else
                                                        <span class="badge badge-pill badge-success text-white">Pekerja</span>
                                                    @endif    
                                                </h4>
                                            </td>
                                            <td align="center">
                                                <span class="badge badge-pill badge-success"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i></span>
                                            </td>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="text-gray">KETERANGAN ROLE / LEVEL</h4>
                                <ul>
                                    <li><span class="badge badge-pill badge-danger">&nbsp;&nbsp;&nbsp;</span> Admin</li>
                                    <li><span class="badge badge-pill badge-primary">&nbsp;&nbsp;&nbsp;</span> Owner</li>
                                    <li><span class="badge badge-pill badge-success">&nbsp;&nbsp;&nbsp;</span> Pekerja</li>
                                </ul>
                            </div>
    
                            <div class="col-4">
                                <h4 class="text-gray">KETERANGAN STATUS</h4>
                                <ul>
                                    <li><span class="badge badge-pill badge-success"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i></span> Akun Aktif</li>
                                    <li><span class="badge badge-pill badge-danger"><i class="fa-solid fa-xmark" style="color: #FFFFFF;"></i></span> Akun Non-aktif</li>
                                </ul>
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
                <h5 class="modal-title">Create Data User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/pengguna">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap..." required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="username" class="form-control" name="username" id="username" placeholder="Username..." required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password..." required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" name="level" id="level" required>
                            <option value="" hidden>-- Pilih Level --</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                            <option value="pekerja">Pekerja</option>
                        </select>
                        @error('level')
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
@foreach ($data_pengguna as $item)
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>                

            <form method="POST" action="/dashboard/pengguna/{{ $row->id }}">
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