@extends('layout.layout')
@section('content')
    <div class="content-body"> 
        <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/bahan-baku">Bahan Baku</a></li>
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
                                        <th>Nama Bahan Baku</th>
                                        <th>Stok</th>
                                        <th>Unit</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahan_baku as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->nama_bahan_baku }}</td>
                                            <td>{{ $row->stok }}</td>
                                            <td>{{ $row->unit }}</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#gambarModal{{ $row->id }}">
                                                    <img src="{{ asset('storage/' . $row->gambar) }}" class="col-sm-5" alt="gambar" style="max-width: 100px; height: auto;">
                                                </a>
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

    <!-- Modal untuk Gambar -->
    @foreach ($bahan_baku as $row)
        <div class="modal fade" id="gambarModal{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Gambar</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $row->gambar) }}" class="mb-3 col-sm-5 mx-auto" alt="gambar">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Bahan Baku</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/bahan-baku" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_bahan_baku">Nama Bahan Baku</label>
                            <input type="text" class="form-control" name="nama_bahan_baku" id="nama_bahan_baku" placeholder="Nama Bahan Baku..." required value="{{ old('nama_bahan_baku') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok..." required value="{{ old('stok') }}">
                            @error('stok')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <select class="form-control" name="unit" id="unit" required>
                                <option value="" hidden>-- Pilih Unit --</option>
                                <option value="kg">Kg</option>
                                <option value="pcs">Pcs</option>
                                <option value="liter">Liter</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Upload Gambar</label>
                            <img id="previewImage" class="img-preview img-fluid mb-3 col-sm-5" src="#" alt="Preview Gambar" style="display: none;">
                            <input class="form-control" type="file" id="gambar" name="gambar" required>
                            @error('gambar')
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
    @foreach ($bahan_baku as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Bahan Baku</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="/dashboard/bahan-baku/{{ $item->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_bahan_baku">Nama Bahan Baku</label>
                                <input type="text" class="form-control" value="{{ $item->nama_bahan_baku }}" name="nama_bahan_baku" id="nama_bahan_bakug" placeholder="Nama Bahan Baku..." required>
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" value="{{ $item->stok }}" name="stok" id="stok" placeholder="Stok..." required>
                            </div>
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <select class="form-control" name="unit" id="unit" required>
                                    <option <?= ($item->unit) == 'kg' ? 'selected' : ''; ?> value="kg">Kg</option>
                                    <option <?= ($item->unit) == 'pcs' ? 'selected' : ''; ?> value="pcs">Pcs</option>
                                    <option <?= ($item->unit) == 'liter' ? 'selected' : ''; ?> value="liter">Liter</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Upload Gambar</label>
                                <!-- Gambar Pratinjau -->
                                <img id="previewImageEdit{{ $item->id }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" src="{{ asset('storage/' . $item->gambar) }}" alt="Preview Gambar">
                                <!-- Input File -->
                                <input class="form-control" type="file" id="gambarEdit{{ $item->id }}" name="gambar" onchange="updatePreview('{{ $item->id }}')">
                                @error('gambar')
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
    @foreach ($bahan_baku as $item)
        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data Bahan Baku</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>                

                    <form method="POST" action="/dashboard/bahan-baku/{{ $row->id }}">
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

    <!-- Script untuk Pratinjau Gambar pada Modal Create -->
    <script>
        // Fungsi untuk menampilkan gambar saat file dipilih
        function previewImage() {
            var input = document.getElementById('gambar');
            var preview = document.getElementById('previewImage');

            input.addEventListener('change', function () {
                var file = input.files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Menampilkan gambar saat file dipilih
                };

                reader.readAsDataURL(file);
            });
        }

        // Panggil fungsi previewImage saat dokumen siap
        document.addEventListener('DOMContentLoaded', function () {
            previewImage();
        });
    </script>

    <!-- Script untuk Pratinjau Gambar pada Modal Edit -->
    <script>
        function updatePreview(itemId) {
            var input = document.getElementById('gambarEdit' + itemId);
            var preview = document.getElementById('previewImageEdit' + itemId);

            input.addEventListener('change', function () {
                var file = input.files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Menampilkan gambar saat file dipilih
                };

                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection