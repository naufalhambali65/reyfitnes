<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Rey Fitnes | Sign Up</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Bootstrap & Template CSS -->
    <link href="/homepage_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/homepage_assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .register-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url("/homepage_assets/img/hero/hero-2.jpg") no-repeat center center/cover;
            position: relative;
            /* font-family: "Work Sans", sans-serif; */
        }

        .register-container::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(17, 17, 17, 0.6);
        }

        .register-box {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.7);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 30px rgba(0, 0, 0);
            animation: fadeInUp 0.8s ease;
        }

        .register-box h2 {
            font-weight: 600;
            color: #444;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 6px;
            padding: 12px 15px;
            border: 1px solid #ccc;
        }

        .btn-register {
            background: #f36100;
            color: #fff;
            border-radius: 6px;
            font-weight: 600;
            padding: 12px;
            transition: 0.3s;
            border: none;
        }

        .btn-register:hover {
            background: #f36100;
        }

        .login-footer {
            margin-top: 15px;
            font-size: 14px;
            color: #6c757d;
        }

        .btn-home {
            color: #fff;
            border-radius: 6px;
            font-weight: 600;
            padding: 10px;
            transition: 0.3s;
            background: #f36100;
            text-decoration: none;
        }

        .btn-home:hover {
            background: #f36100;
            color: black;
        }

        .login-logo {
            height: auto;
            margin-bottom: 20px;
        }

        .logo-wrapper {
            position: relative;
        }

        .logo-wrapper img {
            /* position: absolute; */
            /* top: -150px; */
            /* naikkan logo ke atas navbar */
            /* left: -150px; */
            /* bisa kamu ganti ke center kalau mau */
            /* height: 300px; */
            /* atur tinggi logo */
            height: 150px;
            /* z-index: -1; */
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <style>
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-box text-center">
            <a class="logo-wrapper p-0 mb-3" href="{{ route('home') }}"><img src="/homepage_assets/img/logo/logo.png"
                    alt="Rey Fitnes">
            </a>

            <h2 class="mt-4">Sign Up</h2>
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                        name="email" required />
                    @error('email')
                        <div class="invalid-feedback" style="text-align: left;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                        name="name" required />
                    @error('name')
                        <div class="invalid-feedback" style="text-align: left;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" name="password" id="password" required>

                        <button class="btn" style="background: white; border:1px solid #ccc" type="button"
                            id="togglePasswordBtn1">
                            <i class="fa fa-eye" id="togglePassword1"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback" style="text-align: left;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="form-group mb-3">
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Confirm Password" name="password_confirmation" id="password_confirmation"
                            required>

                        <button class="btn" style="background: white; border:1px solid #ccc" type="button"
                            id="togglePasswordBtn2">
                            <i class="fa fa-eye" id="togglePassword2"></i>
                        </button>
                    </div>

                    @error('password_confirmation')
                        <div class="invalid-feedback" style="text-align: left;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-register w-100">Register</button>
            </form>

            <div class="row login-footer mt-3">
                <div class="col">
                    <a href="{{ route('home') }}" class="btn btn-home mt-3 w-100">Back
                        to Home</a>
                </div>
                <div class="col">
                    <a href="{{ route('login') }}" class="btn btn-home mt-3 w-100">Sign In</a>
                </div>

            </div>
        </div>
    </div>

    <script>
        function setupToggle(passwordInputId, iconId) {
            const input = document.getElementById(passwordInputId);
            const icon = document.getElementById(iconId);

            icon.parentElement.addEventListener("click", () => {
                const isPassword = input.type === "password";

                input.type = isPassword ? "text" : "password";
                icon.classList.toggle("fa-eye");
                icon.classList.toggle("fa-eye-slash");
            });
        }

        setupToggle("password", "togglePassword1");
        setupToggle("password_confirmation", "togglePassword2");
    </script>


    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            })
        </script>
    @endif
</body>

</html>
