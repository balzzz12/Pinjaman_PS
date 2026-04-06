<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PS RENT | Login Experience</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --ps-dark: #050b18;
            --ps-blue: #003791;
            --ps-light-blue: #0070d1;
            --ps-glass: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at top right, #003791, #050b18 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: white;
        }

        /* Background Icons Decoration */
        .bg-decor {
            position: absolute;
            font-size: 25rem;
            color: rgba(255, 255, 255, 0.03);
            z-index: 0;
            pointer-events: none;
        }

        .decor-1 {
            top: -10%;
            left: -5%;
            transform: rotate(-15deg);
        }

        .decor-2 {
            bottom: -10%;
            right: -5%;
            transform: rotate(15deg);
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1000px;
            display: flex;
            padding: 20px;
            animation: fadeIn 1s ease-out;
        }

        /* Sisi Kiri - Branding */
        .brand-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }

        .brand-side i {
            font-size: 5rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #fff, #a5c9fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 15px rgba(0, 112, 209, 0.5));
        }

        .brand-side h1 {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 15px;
        }

        .brand-side p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 400px;
            line-height: 1.6;
        }

        /* Sisi Kanan - Login Card (Glassmorphism) */
        .login-card {
            width: 420px;
            background: var(--ps-glass);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .login-card h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        .form-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--ps-light-blue);
            box-shadow: 0 0 15px rgba(0, 112, 209, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(45deg, var(--ps-blue), var(--ps-light-blue));
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.4s;
            box-shadow: 0 10px 20px rgba(0, 55, 145, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 112, 209, 0.5);
            filter: brightness(1.1);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #d4edda;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            text-align: center;
        }

        .extra-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        .extra-links a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: 0.3s;
        }

        .extra-links a:hover {
            color: white;
        }

        .divider {
            margin: 35px 0 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            line-height: 0.1em;
        }

        .divider span {
            background: #0d1629;
            /* Match blur background */
            padding: 0 15px;
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .register-text {
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .register-text a {
            color: var(--ps-light-blue);
            font-weight: 700;
            text-decoration: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            .brand-side {
                display: none;
            }

            .login-container {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <i class="fab fa-playstation bg-decor decor-1"></i>
    <i class="fas fa-gamepad bg-decor decor-2"></i>

    <div class="login-container">

        <div class="brand-side">
            <i class="fab fa-playstation"></i>
            <h1>PS RENT<br>SYSTEM</h1>
            <p>Level up your gaming experience. Kelola penyewaan konsol generasi terbaru dengan sistem admin premium.</p>
        </div>

        <div class="login-card">
            <h2>Welcome Back</h2>

            @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email Address" required autofocus>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn-login">Play Now</button>

                <div class="extra-links">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                    <a href="#">Help Center</a>
                </div>
            </form>

            <div class="divider">
                <span>New Player?</span>
            </div>

            <div class="register-text">
                Don't have an account? <a href="{{ route('register') }}">Create One</a>
            </div>
        </div>
    </div>

</body>

</html>