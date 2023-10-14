@extends('layout.layout')
@section('content')

    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="/dashboard/profile">Profile</a></li>
                </ol>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4>{{ $title }}</h4>
                            <form action="/dashboard/profile/{{ auth()->user()->id }}" method="post" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama..." value="{{ auth()->user()->name }}" >
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username..." value="{{ auth()->user()->username }}" required>
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="level" class="form-label">Level</label>
                                    <input type="text" class="form-control" id="level" name="level" placeholder="Level..." readonly value="{{ auth()->user()->level }}">
                                </div>
                                
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4>Foto Profile</h4>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Profil</label>
                                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" required>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small>Maksimal file gambar 1 MB</small>
                            </div>
                            <div class="mb-3">
                                @if (auth()->user()->foto)
                                <img id="previewImage" class="img-preview img-fluid mb-3 col-sm-5" src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil">
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        Anda belum mengunggah foto profil.
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
        // Fungsi untuk menampilkan gambar saat file dipilih
        function previewImage() {
            var input = document.getElementById('foto');
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
@endsection