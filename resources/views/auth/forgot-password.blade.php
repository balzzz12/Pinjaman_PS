<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PS RENT | Forgot Password</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --ps-dark: #050b18;
            --ps-blue: #003791;
            --ps-light-blue: #0070d1;
            --ps-glass: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at bottom left, #003791, #050b18 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }

        /* Background Decoration */
        .bg-decor {
            position: absolute;
            font-size: 20rem;
            color: rgba(255, 255, 255, 0.02);
            z-index: 0;
            pointer-events: none;
        }
        .decor-1 { top: -5%; right: -5%; transform: rotate(20deg); }
        .decor-2 { bottom: 5%; left: 2%; transform: rotate(-10deg); }

        .forgot-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
            padding: 20px;
            animation: slideUp 0.8s ease-out;
        }

        .forgot-card {
            background: var(--ps-glass);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .brand-icon {
            font-size: 3rem;
            color: var(--ps-light-blue);
            margin-bottom: 20px;
            filter: drop-shadow(0 0 15px rgba(0, 112, 209, 0.4));
        }

        .forgot-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .forgot-card p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Alert Status */
        .alert-success {
            background: rgba(40, 167, 69, 0.15);
            border: 1px solid #28a745;
            color: #72e58b;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group i.input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 14px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            color: white;
            outline: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .form-group input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--ps-light-blue);
            box-shadow: 0 0 15px rgba(0, 112, 209, 0.2);
        }

        .btn-reset {
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
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 112, 209, 0.4);
        }

        .back-to-login {
            margin-top: 25px;
            display: block;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: 0.3s;
        }

        .back-to-login:hover {
            color: white;
        }

        .back-to-login i {
            margin-right: 5px;
            font-size: 0.8rem;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<i class="fas fa-key bg-decor decor-1"></i>
<i class="fab fa-playstation bg-decor decor-2"></i>

<div class="forgot-container">
    <div class="forgot-card">
        <i class="fab fa-playstation brand-icon"></i>
        <h2>Reset Password</h2>
        <p>Masukkan alamat email akun Anda dan kami akan mengirimkan link untuk mengatur ulang kata sandi Anda.</p>

        @if (session('status'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Email Address" required autofocus>
            </div>

            <button type="submit" class="btn-reset">Kirim Link Reset</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">
            <i class="fas fa-arrow-left"></i> Kembali ke Login
        </a>
    </div>
</div>

</body>
</html>