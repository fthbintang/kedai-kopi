@extends('layout.layout')
@section('content')
    <div class="content-body"> 
        <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/barang-masuk">Barang Masuk</a></li>
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
                                        <th>Nama Barang</th>
                                        <th>Pengguna</th>
                                        <th>Stok Masuk</th>
                                        <th>Waktu Masuk</th>
                                        <th>Stok Sebelum</th>
                                        <th>Stok Sesudah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuk as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->barang->nama_barang }}</td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>{{ $row->stok_masuk }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ $row->stok_sebelum }}</td>
                                            <td>{{ $row->stok_sesudah }}</td>
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

            var file = input.files[0];

            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Menampilkan gambar saat file dipilih
            };

            reader.readAsDataURL(file);
        }
    </script>




@endsection