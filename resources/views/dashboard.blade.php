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
                    <div class="card-body">
                        <h1>Selamat Datang, {{ auth()->user()->name }}</h1>
                        <a href="#modalCheckin{{ auth()->user()->id }}" data-toggle="modal" class="btn btn-xs btn-success">
                            <i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check In !
                        </a>
                        <a href="#modalCheckout{{ auth()->user()->id }}" data-toggle="modal" class="btn btn-xs btn-danger">
                            <i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check Out !
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Presensi Checkin --}}
    <div class="modal fade" id="modalCheckin{{ auth()->user()->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lakukan Check In !</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/presensi/checkin/{{ auth()->user()->id }}">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto temporibus accusamus, doloribus, praesentium velit quisquam quibusdam dignissimos sunt autem voluptates deleniti earum blanditiis cupiditate dolor alias? Architecto animi nihil atque.</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check In !</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Presensi Checkout --}}
    <div class="modal fade" id="modalCheckout{{ auth()->user()->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lakukan Check In !</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>                

                <form method="POST" action="/dashboard/presensi/checkout/{{ auth()->user()->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto temporibus accusamus, doloribus, praesentium velit quisquam quibusdam dignissimos sunt autem voluptates deleniti earum blanditiis cupiditate dolor alias? Architecto animi nihil atque.</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-check" style="color: #FFFFFF;"></i> Check Out !</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection