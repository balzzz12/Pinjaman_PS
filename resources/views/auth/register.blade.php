<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PS RENT | Create Account</title>

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
            overflow-x: hidden;
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

        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1100px;
            display: flex;
            padding: 20px;
            animation: slideUp 0.8s ease-out;
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
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--ps-light-blue);
            filter: drop-shadow(0 0 15px rgba(0, 112, 209, 0.4));
        }

        .brand-side h1 {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .brand-side p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            max-width: 450px;
        }

        /* Sisi Kanan - Register Card */
        .register-card {
            width: 450px;
            background: var(--ps-glass);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .register-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid #dc3545;
            color: #ff8e97;
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

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.3);
            transition: 0.3s;
        }
        .toggle-password:hover { color: white; }

        .btn-register {
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
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 112, 209, 0.4);
        }

        .divider {
            margin: 30px 0 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            line-height: 0.1em;
        }

        .divider span {
            background: #081125; /* Match card background */
            padding: 0 15px;
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .login-text {
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .login-text a {
            color: var(--ps-light-blue);
            font-weight: 700;
            text-decoration: none;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 900px) {
            .brand-side { display: none; }
            .register-container { justify-content: center; }
        }
    </style>
</head>
<body>

<i class="fas fa-shapes bg-decor decor-1"></i>
<i class="fab fa-playstation bg-decor decor-2"></i>

<div class="register-container">
    
    <div class="brand-side">
        <i class="fab fa-playstation"></i>
        <h1>JOIN THE<br>ELITE SQUAD</h1>
        <p>Daftar sekarang dan nikmati kemudahan akses penyewaan PlayStation tercepat. Rasakan pengalaman gaming premium dalam satu genggaman.</p>
    </div>

    <div class="register-card">
        <h2>Create Account</h2>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div><i class="fas fa-info-circle mr-2"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="form-group">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
            </div>

            <div class="form-group">
                <i class="fas fa-shield-alt input-icon"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
            </div>

            <button type="submit" class="btn-register">Start Playing</button>
        </form>

        <div class="divider">
            <span>Already a Member?</span>
        </div>

        <div class="login-text">
            Have an account? <a href="{{ route('login') }}">Log In Here</a>
        </div>
    </div>
</div>

<script>
    function togglePassword(id, icon) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
            input.type = "password";
            icon.classList.replace("fa-eye", "fa-eye-slash");
        }
    }
</script>

</body>
</html>