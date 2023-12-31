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
                                <h3>Nama sesi: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangMasuk->nama_sesi ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <h3>Pengguna: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangMasuk->user->name ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <h3>Waktu input: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangMasuk->created_at ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <h3>Keterangan: </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <p> {{ $barangMasuk->keterangan ?? 'Tidak ada Data' }} </p>
                            </div>
                        </div>
                        @if ($barangMasuk->status != 'ACC')
                            @auth
                                @if(Auth::user()->level == 1 || Auth::user()->level == 3)
                                    <div class="row">
                                        <div class="col-sm">
                                            <a href="#modalEditBarangMasuk{{ $barangMasuk->id }}" data-toggle="modal" class="btn btn-xs btn-primary">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="#modalDeleteBarangMasuk{{ $barangMasuk->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endauth
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
                                @if (!empty($listBarangMasuk->first()->barangMasuk->status))
                                    <p>{{ $listBarangMasuk->first()->barangMasuk->status }}</p>
                                @else
                                    <p>Tidak ada Status</p>
                                @endif
                            </div>
                        </div>
                        @if ($barangMasuk->status != 'ACC')
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
                            @auth
                                @if (Auth::user()->level == 1 || Auth::user()->level == 3)
                                    @if ($barangMasuk->status != 'ACC')
                                        <button type="button" class="btn btn-primary btn-round ml-2" data-toggle="modal" data-target="#modalCreateListBarangMasuk">
                                            <i class="fa fa-plus"></i> Tambah Data
                                        </button>
                                    @endif
                                @endif
                            @endauth

                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Awal</th> 
                                        <th>Stok Masuk</th>
                                        <th>Stok Final</th>
                                        <th>Waktu Masuk</th>
                                        @if (Auth::user()->level == 1 || Auth::user()->level == 3)
                                            @if ($barangMasuk->status != 'ACC')
                                                <th>Aksi</th>
                                            @endif
                                        @endif
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
                                            @auth
                                                @if (Auth::user()->level == 1 || Auth::user()->level == 3)
                                                    @if ($barangMasuk->status != 'ACC')
                                                        <td>
                                                            <a href="#modalDelete{{ $row->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i> Hapus
                                                            </a>
                                                        </td>
                                                    @endif
                                                @endif
                                            @endauth
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

    {{-- Modal Edit Barang Masuk --}}
    <div class="modal fade" id="modalEditBarangMasuk{{ $barangMasuk->id }}" name="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/barang-masuk/{{ $barangMasuk->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_sesi">Nama Sesi</label>
                            <input type="text" class="form-control @error('nama_sesi') is-invalid @enderror" name="nama_sesi" id="nama_sesi" value="{{ $barangMasuk->nama_sesi }}" placeholder="Nama Sesi..." required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" value="{{ $barangMasuk->keterangan }}" placeholder="Opsional">
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
    
    {{-- Modal Delete Barang Masuk--}}
    <div class="modal fade" id="modalDeleteBarangMasuk{{ $barangMasuk->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/barang-masuk/{{ $barangMasuk->id }}">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>Apakah Anda yakin ingin menghapus data ini ?</h5>
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

    {{-- Modal Create List Barang Masuk --}}
    <div class="modal fade" id="modalCreateListBarangMasuk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Barang Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/barang-masuk/list-barang-masuk">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="addInput">Tambah Input</button>
                            <legend>Harap lengkapi form dahulu sebelum tambah input!</legend>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="barang_masuk_id" id="barang_masuk_id" value="{{ $barangMasuk->id }}">
                        </div>
                        <div class="form-group">
                            <label for="barang_id">Nama Barang</label>
                            <select class="form-control" name="barang_id[]" id="barang_id" style="width: 100%;" required>
                                <option value="" selected disabled></option> 
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stok_sebelum">Stok saat ini</label>
                            <input type="number" class="form-control @error('stok_sebelum') is-invalid @enderror" name="stok_sebelum[]" id="stok_sebelum" placeholder="Isi Barang Dahulu..." required readonly>
                        </div>
                        <div class="form-group">
                            <label for="stok_masuk">Stok masuk</label>
                            <input type="number" class="form-control @error('stok_masuk') is-invalid @enderror" name="stok_masuk[]" id="stok_masuk" placeholder="Stok..." required>
                        </div>
                        <hr>

                        <div id="dynamicInputsContainer">
                            <!-- Input dinamis akan ditambahkan di sini -->
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

    {{-- Modal Delete List Barang Masuk --}}
    @foreach ($listBarangMasuk as $item)
    <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/barang-masuk/list-barang-masuk/{{ $item->id }}">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>Apakah Anda Yakin ingin menghapus data ini?</h5>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // Autocorrect Select2 Create
            $('#barang_id').select2({
                dropdownParent: $('#modalCreateListBarangMasuk'),
                placeholder: "Barang..",
                allowClear: true
            });

            // Event handler ketika memilih barang (Pengisian Stok Otomatis)
            $('#barang_id').on('change', function () {
                var selectedBarangId = $(this).val();
                if (selectedBarangId) {
                    // Mengambil stok dari barang terkait
                    var selectedBarang = <?php echo json_encode($barangs, JSON_HEX_TAG); ?>;
                    var stokSebelumInput = $('#stok_sebelum');
                    stokSebelumInput.val(selectedBarang.find(barang => barang.id == selectedBarangId).stok);
                }
            });

            // Input Dinamis
            var dynamicInputs = 0;

            // Tombol "Tambah Input" diklik
            $('#addInput').on('click', function() {
                dynamicInputs++;

                var newInput = `
                    <div class="form-group">
                        <label for="barang_id_${dynamicInputs}">Nama Barang</label>
                        <select class="form-control" name="barang_id[]" id="barang_id_${dynamicInputs}" style="width: 100%;">
                            <option value="" selected disabled>Pilih Barang</option> 
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok_sebelum_${dynamicInputs}">Stok saat ini</label>
                        <input type="number" class="form-control" name="stok_sebelum[]" id="stok_sebelum_${dynamicInputs}" placeholder="Pilih Barang Dahulu..." required readonly>
                    </div>
                    <div class="form-group">
                        <label for="stok_masuk_${dynamicInputs}">Stok masuk</label>
                        <input type="number" class="form-control" name="stok_masuk[]" id="stok_masuk_${dynamicInputs}" placeholder="Stok..." required>
                    </div>
                    <hr>`

                $('#dynamicInputsContainer').append(newInput);

                // Inisialisasi Select2 untuk input dinamis
                $(`#barang_id_${dynamicInputs}`).select2({
                    placeholder: 'Barang..',
                    allowClear: true
                });

                // Event handler ketika memilih barang pada input dinamis
                $(`#barang_id_${dynamicInputs}`).on('change', function () {
                    var selectedBarangId = $(this).val();
                    var stokSebelumInput = $(`#stok_sebelum_${dynamicInputs}`);

                    if (selectedBarangId) {
                        // Mengambil stok dari barang terkait
                        var selectedBarang = <?php echo json_encode($barangs, JSON_HEX_TAG); ?>;
                        stokSebelumInput.val(selectedBarang.find(barang => barang.id == selectedBarangId).stok);
                    } else {
                        stokSebelumInput.val(''); // Reset stok saat memilih barang
                    }
                });
            });
        });
    </script>

    <script>
        // Menambahkan event listener untuk tombol ACC
        document.getElementById('accButton').addEventListener('click', function() {
            // Menampilkan pesan konfirmasi menggunakan SweetAlert
            swal({
                title: "Apakah Anda sudah yakin? ",
                text: "Setelah ACC, data ini tidak dapat diubah dan dihapus lagi!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Batal",
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Ya, ACC",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: true,
                    }
                }
            }).then((result) => {
                // Jika pengguna menekan tombol "Ya, ACC", maka redirect ke route ACC
                if (result) {
                    window.location.href = "/dashboard/barang-masuk/{{ $barangMasuk->id }}/acc";
                }
            });
        });

        // Menambahkan event listener untuk tombol Not ACC
        document.getElementById('notAccButton').addEventListener('click', function() {
            // Menampilkan pesan konfirmasi menggunakan SweetAlert
            swal({
                title: "Konfirmasi Tidak ACC",
                text: "Apakah Anda yakin ingin Tidak ACC?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Batal",
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Ya, Tidak ACC",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true,
                    }
                }
            }).then((result) => {
                // Jika pengguna menekan tombol "Ya, Tidak ACC", maka redirect ke route Not ACC
                if (result) {
                    window.location.href = "/dashboard/barang-masuk/{{ $barangMasuk->id }}/not-acc";
                }
            });
        });
    </script>

@endpush
