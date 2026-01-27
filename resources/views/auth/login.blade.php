<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Finda UK</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://preview.colorlib.com/theme/bootstrap/login-form-20/css/style.css">
    <style>
        .ftco-section {
            padding-top: 5%;
            padding-bottom: 0px;
        }
    </style>
</head>

<body class="img js-fullheight" style="background-image: url({{asset('assets/img/all-images/hero/hero-img2.png')}});">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Property Finda</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Have an account?</h3>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST" class="signin-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="login" class="form-control" placeholder="Username or Email"
                                    value="{{ old('login') }}" required autofocus>
                                @error('login')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                @error('username')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control"
                                    placeholder="Password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="{{ route('password.request') }}" style="color: #fff">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                        <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
                        <div class="social d-flex text-center">
                            <a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span>
                                Facebook</a>
                            <a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span>
                                Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-20/js/jquery.min.js"></script>
    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-20/js/popper.js"></script>
    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-20/js/bootstrap.min.js"></script>
    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-20/js/main.js"></script>
</body>

</html>