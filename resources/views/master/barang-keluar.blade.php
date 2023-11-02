@extends('layout.layout')
@section('content')
    <div class="content-body"> 
        <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/barang-keluar">Barang Keluar</a></li>
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
                                        <th>Stok Keluar</th>
                                        <th>Waktu Masuk</th>
                                        <th>Stok Sebelum</th>
                                        <th>Stok Sesudah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangKeluar as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->barang->nama_barang }}</td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>{{ $row->stok_keluar }}</td>
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

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Barang Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/barang-keluar">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="addInput">Tambah Input</button>
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
                            <label for="stok_keluar">Stok Keluar</label>
                            <input type="number" class="form-control @error('stok_keluar') is-invalid @enderror" name="stok_keluar[]" id="stok_keluar" placeholder="Stok..." required>
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

    <!-- {{-- Modal Edit --}}
    @foreach ($barangKeluar as $item)
    <div class="modal fade" id="modalEdit{{ $item->id }}" name="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="/dashboard/barang-masuk/{{ $item->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang_id">Nama Barang</label>
                                <input type="text" class="form-control @error('barang_id') is-invalid @enderror" name="barang_id" id="barang_id" value="{{ $barang->nama_barang }}" placeholder="Isi Barang Dahulu..." required readonly>
                        </div>
                        <div class="form-group">
                            <label for="stok_sebelum">Stok saat ini</label>
                            <input type="number" class="form-control @error('stok_sebelum') is-invalid @enderror" name="stok_sebelum" id="stok_sebelum" value="{{ $item->stok_sebelum }}" placeholder="Isi Barang Dahulu..." required readonly>
                        </div>
                        <div class="form-group">
                            <label for="stok_masuk">Stok masuk</label>
                            <input type="number" class="form-control @error('stok_masuk') is-invalid @enderror" name="stok_masuk" id="stok_masuk" value="{{ $item->stok_masuk }}" placeholder="Stok..." required>
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
    @endforeach -->


    {{-- Modal Delete --}}
    @foreach ($barangKeluar as $item)
    <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/barang-keluar/{{ $row->id }}">
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
@push('scripts')
    <script>
        $(document).ready(function() {
            // Autocorrect Select2 Create
            $('#barang_id').select2({
                dropdownParent: $('#modalCreate'),
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
                        <label for="stok_keluar_${dynamicInputs}">Stok keluar</label>
                        <input type="number" class="form-control" name="stok_keluar[]" id="stok_keluar_${dynamicInputs}" placeholder="Stok..." required>
                    </div>;
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
@endpush
