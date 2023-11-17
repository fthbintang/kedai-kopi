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
    <!-- CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
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

        {{-- Including Navbar --}}
        @include('layout.navbar')

        {{-- Including Sidebar --}}
        @include('layout.sidebar')

        {{-- Block of content will show here ! --}}
        @yield('content')
        
        {{-- Including Footer --}}
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

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Autocorret Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/f7295b3135.js" crossorigin="anonymous"></script>

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
                        title: "Success !",
                        text: "{{ session('success') }}",
                        icon: "success",
                        buttons: {
                            confirm: {
                                text: "Konfirmasi",
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
                        title: "Error !",
                        text: "{{ session('error') }}",
                        icon: "error",
                        buttons: {
                            confirm: {
                                text: "Konfirmasi",
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
    
    
    <!-- Validasi Pengguna -->
    @if($errors->has('create_name') || $errors->has('create_username') || $errors->has('create_password') || $errors->has('edit_level'))
        <script>
            $(document).ready(function(){
                $('#modalCreate').modal({show: true});
            });
        </script>
    @endif

    @if($errors->has('edit_name') || $errors->has('edit_username') || $errors->has('edit_password') || $errors->has('edit_level'))
        <script>
            $(document).ready(function() {
                $('#modalEdit{{ $item->id }}').modal('show');
            });
        </script>
    @endif
    
    <!-- Validasi Barang -->
    @if($errors->has('create_nama_barang') || $errors->has('create_stok')  || $errors->has('create_unit') || $errors->has('create_gambar'))
        <script>
            $(document).ready(function(){
                $('#modalCreate').modal({show: true});
            });
        </script>
    @endif

    @if($errors->has('edit_nama_barang') || $errors->has('edit_stok') || $errors->has('edit_unit') ||$errors->has('edit_gambar'))
        <script>
            $(document).ready(function() {
                $('#modalEdit{{ $item->id }}').modal('show');
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>