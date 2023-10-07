<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        @include('layout.navbar')

        @include('layout.sidebar')
        
        <div class="content-body"> 
            <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="/atribut">Atribut</a></li>
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
                                <button type="button" class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalCreate"><i class="fa fa-plus"></i>Tambah Data</button>
                            </div> 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Stok</th>
                                            <th>Gambar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($atribut as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->nama_barang }}</td>
                                                <td>{{ $row->stok }}</td>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#gambarModal{{ $row->id }}">
                                                        <img src="{{ asset('storage/' . $row->gambar) }}" class="col-sm-5" alt="gambar" style="max-width: 100px; height: auto;">
                                                    </a>
                                                </td>


                                                <td>
                                                    <a href="#modalEdit{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-primary">
                                                        <i class="fa fa-edit">Edit</i>
                                                    </a>    
                                                    <a href="#modalDelete{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                                        <i class="fa fa-trash">Hapus</i>
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
    </div>

    <!-- Modal untuk Gambar -->
    @foreach ($atribut as $row)
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
                    <h5 class="modal-title">Tambah Data Atribut</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/atribut" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang..." required value="{{ old('nama_barang') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok..." required value="{{ old('stok') }}">
                            @error('stok')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
    @foreach ($atribut as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Atribut</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="atribut/{{ $item->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" value="{{ $item->nama_barang }}" name="nama_barang" id="nama_barang" placeholder="Nama Barang..." required>
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" value="{{ $item->stok }}" name="stok" id="stok" placeholder="Stok..." required>
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
    @foreach ($atribut as $item)
        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data Atribut</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>                

                    <form method="POST" action="/atribut/{{ $row->id }}">
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
        
        @include('layout.footer')
        
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="/assets/plugins/common/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
    <script src="/assets/js/styleSwitcher.js"></script>

    <script src="/assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (session('success'))
        <script>
            var SweetAlertDemo = function() {
                var initDemos = function() {
                    swal({
                        title: "Berhasil!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        buttons: {
                            confirm: {
                                text: "Confirm Me",
                                value: true,
                                visible: true,
                                className: "btn btn-success",
                                closeModal: true,
                            }
                        }
                    });
                };

                return {
                    init: function() {
                        initDemos();
                    },
                };
            }();

            jQuery(document).ready(function() {
                SweetAlertDemo.init();
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            var SweetAlertDemo = function() {
                var initDemos = function() {
                    swal({
                        title: "Berhasil!",
                        text: "{{ session('error') }}",
                        icon: "error",
                        buttons: {
                            confirm: {
                                text: "Confirm Me",
                                value: true,
                                visible: true,
                                className: "btn btn-success",
                                closeModal: true,
                            }
                        }
                    });
                };

                return {
                    init: function() {
                        initDemos();
                    },
                };
            }();

            jQuery(document).ready(function() {
                SweetAlertDemo.init();
            });
        </script>
    @endif

    @if ($errors->has('stok') || $errors->has('harga'))
    <script>
        // Periksa apakah ada pesan kesalahan untuk stok atau harga
            // Tampilkan modal tambah data
            $('#modalCreate').modal('show');
    </script>
    @endif

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
        // Panggil fungsi previewImage saat dokumen siap
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($atribut as $item)
                previewImageEdit('{{ $item->id }}');
            @endforeach
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


</body>

</html>