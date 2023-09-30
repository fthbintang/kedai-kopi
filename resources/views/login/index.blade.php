
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | Kedai Kopi</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        .custom-alert {
            position: relative;
            padding: 15px;
            background-color: #f44336; /* Warna latar belakang untuk alert error */
            color: #fff;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    
        .custom-alert.success {
            background-color: #4CAF50; /* Warna latar belakang untuk alert sukses */
        }
    
        .close-alert {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            cursor: pointer;
            background-color: #f44336;
            border: none;
            border-radius: 0 4px 4px 0;
        }

        .close-alert:focus {
            outline: none;
        }
    
        .alert-message {
            padding-right: 30px;
        }
    </style>
    
</head>

<body class="h-100">
    
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

    



    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.html"> <h4>Silakan Login</h4></a>

                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                
                                @if(session()->has('loginError'))
                                    <div class="custom-alert error">
                                        <span class="alert-message">{{ session('loginError') }}</span>
                                        <button class="close-alert" onclick="closeAlert()">&times;</button>
                                    </div>
                                @endif

        
                                <form class="mt-5 mb-5 login-input" action="/login" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <input type="username" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username" autofocus required value="{{ old('username') }}">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <button class="btn login-form__btn submit w-100">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="/assets/plugins/common/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
    <script src="/assets/js/styleSwitcher.js"></script>

    <script>
        function closeAlert() {
            var alert = document.querySelector('.custom-alert');
            alert.style.display = 'none';
        }
    </script>
</body>
</html>





