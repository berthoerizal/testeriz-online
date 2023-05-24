<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}" />
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form method="POST" class="sign-in-form" action="{{ route('register') }}">
                    @csrf
                    <h2 class="title">Register</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required class="@error('name') is-invalid @enderror" placeholder="Nama Lengkap" autofocus>
                    </div>
                    @error('name')
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: red;">{{ $message }}</strong>
                    </span>
                    <br>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    </div>
                    @error('email')
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: red;">{{ $message }}</strong>
                    </span>
                    <br>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                    </div>
                    @error('password')
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: red;">{{ $message }}</strong>
                    </span>
                    <br>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password">
                    </div>
                    <button type="submit" class="btn solid">
                        {{ __('Register') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Sudah punya akun ?</h3>
                    <p>
                        <a href="{{ url('/') }}" style="text-decoration:none; color: white;"><b>TESTERIZ</b></a>
                        adalah
                        sistem yang menyediakan fungsi atau fitur yang biasanya dibutuhkan dalam pembuatan website
                        dengan framework Laravel.
                    </p>
                    <a href="{{ route('login') }}"><button class="btn btn-outline-primary" id="sign-up-btn">Login</button>
                    </a>
                </div>
                <img src="{{ asset('assets/login/img/log.svg') }}" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/login/app.js') }}"></script>
</body>

</html>