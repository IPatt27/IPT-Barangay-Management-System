<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Barangay Management — Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }

        .register-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 28px;
        }

        .register-logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 12px;
        }

        .register-logo h2 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 2px;
            text-align: center;
        }

        .register-logo p {
            font-size: 12px;
            color: #888;
            text-align: center;
        }

        .divider {
            border-top: 1px solid #e5e5e5;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 4px;
        }

        .form-control {
            font-size: 14px;
            border: 1px solid #e5e5e5;
            border-radius: 7px;
            padding: 10px 14px;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 150ms ease;
        }

        .form-control:focus {
            border-color: #1a3a5c;
            box-shadow: none;
        }

        .btn-register {
            background: #1a3a5c;
            color: #ffffff;
            border: none;
            border-radius: 7px;
            padding: 11px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            width: 100%;
            cursor: pointer;
            transition: background 150ms ease;
            margin-top: 8px;
        }

        .btn-register:hover {
            background: #2d5f8e;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #888;
        }

        .login-link a {
            color: #1a3a5c;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-msg {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <div class="register-card">

        {{-- Logo and Barangay Name --}}
        <div class="register-logo">
            <img src="/BarangayNewEra.jpg" alt="Barangay Logo">
            <h2>Barangay New Era</h2>
            <p>District VI, Quezon City</p>
        </div>

        <div class="divider"></div>

        {{-- Register Form --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter your full name" required>
                @error('name')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter your email" required>
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="btn-register">Register</button>

        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in here</a>
        </div>

    </div>

</body>
</html>