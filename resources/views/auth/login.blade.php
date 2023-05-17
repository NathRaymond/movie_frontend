<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title data-setting="app_name" data-rightJoin=" Responsive Bootstrap 5 Admin Dashboard Template">Crud</title>
    <meta name="description" content="Crud">
    <meta name="Crud">
    <meta name="author" content="Iqonic Design">
    <meta name="DC.title" content="Crud">
    <!-- Favicon -->
    <link rel="shortcut icon"
        href="https://templates.iqonic.design/product/qompac-ui/html/dist/assets/images/favicon.ico">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">

    <!-- Crud-ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/qompac-ui.minf700.css?v=1.0.1') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.minf700.css?v=1.0.1') }}">
    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark.minf700.css?v=1.0.1') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.minf700.css?v=1.0.1') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.minf700.css?v=1.0.1') }}">



    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body ">
                <img src="https://templates.iqonic.design/product/qompac-ui/html/dist/assets/images/loader.webp"
                    alt="loader" class="image-loader img-fluid ">
            </div>
        </div>
    </div>
    <!-- loader END -->
    <div class="wrapper">
        <section class="login-content overflow-hidden">
            <div class="row no-gutters align-items-center bg-white">
                <div class="col-md-12 col-lg-6 align-self-center">
                    <a href="#"
                        class="navbar-brand d-flex align-items-center mb-3 justify-content-center text-primary">
                        <div class="logo-normal">
                            <svg class="" viewBox="0 0 32 32" width="80px" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.25333 2H22.0444L29.7244 15.2103L22.0444 28.1333H7.25333L0 15.2103L7.25333 2ZM11.2356 9.32316H18.0622L21.3334 15.2103L18.0622 20.9539H11.2356L8.10669 15.2103L11.2356 9.32316Z"
                                    fill="currentColor" />
                                <path d="M23.751 30L13.2266 15.2103H21.4755L31.9999 30H23.751Z" fill="#3FF0B9" />
                            </svg>
                        </div>
                        <h2 class="logo-title ms-3 mb-0" >Crud Assesment Test</h2>
                    </a>
                    <div class="row justify-content-center pt-5">
                        <div class="col-md-9">
                            <div class="card  d-flex justify-content-center mb-0 auth-card iq-auth-form">
                                <div class="card-body">
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <p class="text-center">Login to stay connected.</p>
                                    <form action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" aria-describedby="email"
                                                        placeholder="email@gmail.com" value="{{ old('email') }}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="password" aria-describedby="password" placeholder="xxxx">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <div class="form-check mb-3">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">Remember
                                                        Me</label>
                                                </div>
                                                <a href="#">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Sign In</button>
                                        </div>
                                        <p class="text-center my-3"></p>
                                        <div class="d-flex justify-content-center">

                                        </div>
                                        <p class="mt-3 text-center">
                                            Don’t have an account? <a href="/register" class="text-underline">Click
                                                here to sign up.</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none bg-primary p-0  overflow-hidden">
                    <img src="{{ asset('assets/images/auth/01.png') }}" class="img-fluid gradient-main"
                        alt="images" loading="lazy">
                </div>
            </div>
        </section>
    </div>
    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <!-- Plugin Scripts -->









    <!-- Slider-tab Script -->
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>





    <!-- Lodash Utility -->
    <script src="{{ asset('assets/vendor/lodash/lodash.min.js') }}"></script>
    <!-- Utilities Functions -->
    <script src="{{ asset('assets/js/iqonic-script/utility.min.js') }}"></script>
    <!-- Settings Script -->
    <script src="{{ asset('assets/js/iqonic-script/setting.min.js') }}"></script>
    <!-- Settings Init Script -->
    <script src="{{ asset('assets/js/setting-init.js') }}"></script>
    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>
    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/js/charts/widgetchartsf700.js?v=1.0.1') }}" defer></script>
    <!-- Dashboard Script -->
    <script src="{{ asset('assets/js/charts/dashboardf700.js?v=1.0.1') }}" defer></script>
    <!-- qompacui Script -->
    <script src="{{ asset('assets/js/qompac-uif700.js?v=1.0.1') }}" defer></script>
    <script src="{{ asset('assets/js/sidebarf700.js?v=1.0.1') }}" defer></script>

</body>

</html>
