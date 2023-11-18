@extends('layout.layout')

@section('content')
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/dashboard/generate-laporan">Generate Laporan</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h3 class="card-title">Generate Laporan Presensi</h3>
                        </div> 
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/dashboard/generate-laporan/presensi">
                            @csrf
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="datepicker" class="form-label">Pilih Bulan dan Tahun*</label>
                                        <input type="text" name="date" id="datepicker" class="form-control" required/>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Pilih Status Kehadiran</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">-Pilih-</option>
                                            <option value="0">Tepat Waktu</option>
                                            <option value="1">Terlambat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Pilih Karyawan</label>
                                        <select class="form-control" name="user_id" id="status">
                                            <option value="">-Pilih-</option>
                                            @foreach ($karyawan as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="ekstensi" class="form-label">Pilih Extensi Laporan*</label>
                                        <select class="form-control" name="ekstensi" id="ekstensi" required>
                                            <option value="">-Pilih-</option>
                                            <option value="pdf">PDF</option>
                                            <option value="csv">CSV</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control"><i class="fa-solid fa-print"></i> Generate</button>
                                </div>
                            </div>
                        </form>
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
                        <div class="d-flex align-item-center">
                            <h3 class="card-title">Generate Laporan Gaji Karyawan</h3>
                        </div> 
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/dashboard/generate-laporan/gaji">
                            @csrf
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="datepicker" class="form-label">Pilih Bulan dan Tahun*</label>
                                        <input type="text" name="date" id="datepicker2" class="form-control" required/>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Pilih Karyawan</label>
                                        <select class="form-control" name="user_id" id="status">
                                            <option value="">-Pilih-</option>
                                            @foreach ($karyawan as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="is_paid" class="form-label">Pilih Status Gaji</label>
                                        <select class="form-control" name="is_paid" id="is_paid">
                                            <option value="">-Pilih-</option>
                                            <option value="dibayar">Dibayar</option>
                                            <option value="belum_dibayar">Belum Dibayar</option>    
                                        </select>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="ekstensi" class="form-label">Pilih Extensi Laporan*</label>
                                        <select class="form-control" name="ekstensi" id="ekstensi" required>
                                            <option value="">-Pilih-</option>
                                            <option value="pdf">PDF</option>
                                            <option value="csv">CSV</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control"><i class="fa-solid fa-print"></i> Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Generate Laporan Pendapatan Harian -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h3 class="card-title">Generate Laporan Pendapatan Harian</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/dashboard/generate-laporan/pendapatan">
                            @csrf
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="datepickerPendapatan" class="form-label">Pilih Bulan dan Tahun*</label>
                                        <input type="text" name="date" id="datepicker3" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="ekstensi" class="form-label">Pilih Extensi Laporan*</label>
                                        <select class="form-control" name="ekstensi" id="ekstensi" required>
                                            <option value="">-Pilih-</option>
                                            <option value="pdf">PDF</option>
                                            <option value="csv">CSV</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control"><i class="fa-solid fa-print"></i> Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $("#datepicker").datepicker({
        format: "MM - yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });

    $("#datepicker2").datepicker({
        format: "MM - yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });

    $("#datepicker3").datepicker({
        format: "MM - yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });
</script>
@endsection