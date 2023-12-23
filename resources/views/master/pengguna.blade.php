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
                                    <tr align="center">
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
                                                    @if ($row->level == 1)
                                                        <span class="badge badge-pill badge-danger">Admin</span>
                                                    @elseif ($row->level == 2)
                                                        <span class="badge badge-pill badge-primary">Owner</span>
                                                    @else
                                                        <span class="badge badge-pill badge-success text-white">Pekerja</span>
                                                    @endif    
                                                </h4>
                                            </td>
                                            <td align="center">
                                                @if ($row->status == 'aktif')
                                                    <span class="badge badge-pill badge-success"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i></span>
                                                @else
                                                    <span class="badge badge-pill badge-danger"><i class="fa-solid fa-xmark" style="color: #FFFFFF;"></i></span>
                                                @endif
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
                <h5 class="modal-title">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/pengguna">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" name="create_name" id="name" placeholder="Nama Lengkap..." required>
                        @error('create_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="create_username" id="username" placeholder="Username..." required>
                        @error('create_username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="create_password" id="password" placeholder="Password..." required>
                        @error('create_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" name="create_level" id="level" required>
                            <option value="" hidden>-- Pilih Level --</option>
                            <option value="1">Admin</option>
                            <option value="2">Owner</option>
                            <option value="3">Pekerja</option>
                        </select>
                        @error('create_level')
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
@foreach ($data_pengguna as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/pengguna/{{ $item->id }}">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" name="edit_name" id="name" placeholder="Nama Lengkap..." value="{{ $item->name }}" required>
                        @error('edit_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="edit_username" id="username" placeholder="Username..." value="{{ $item->username }}" required>
                        @error('edit_username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="edit_password" id="password" placeholder="Password...">
                        @error('edit_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" name="edit_level" id="level" required>
                            <option value="1" <?= ($item->level) == '1' ? 'selected' : ''; ?>>Admin</option>
                            <option value="2" <?= ($item->level) == '2' ? 'selected' : ''; ?>>Owner</option>
                            <option value="3" <?= ($item->level) == '3' ? 'selected' : ''; ?>>Pekerja</option>
                        </select>
                        @error('edit_level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="edit_status" id="status" required>
                            <option value="aktif" <?= ($item->level) == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="nonaktif" <?= ($item->status) == 'nonaktif' ? 'selected' : ''; ?>>Non-Aktif</option>
                        </select>
                        @error('edit_level')
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
@foreach ($data_pengguna as $item)
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>                

            <form method="POST" action="/dashboard/pengguna/{{ $item->id }}">
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