<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام قاعات التدريب | مديرية الشئون الصحية بسوهاج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(rgba(13, 110, 253, 0.85), rgba(13, 110, 253, 0.85)),
                        url("{{ asset('images/training_bg.jpg') }}") no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Tajawal', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 380px;
            padding: 1.7rem;
            text-align: center;
        }

        .login-card img {
            width: 75px;
            margin-bottom: 0.8rem;
        }

        .login-header h2 {
            font-weight: 700;
            color: #0d6efd;
            font-size: 1.3rem;
        }

        .login-header p {
            color: #555;
            margin-bottom: 1.2rem;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
        }

        button[type="submit"] {
            border-radius: 10px;
            padding: 9px;
            width: 100%;
            background-color: #0d6efd;
            border: none;
            color: #fff;
            font-weight: bold;
            transition: background 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0b5ed7;
        }

        .footer-text {
            margin-top: 1rem;
            font-size: 13px;
            color: #777;
        }

        .footer-text hr {
            margin: 0.8rem 0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/sohag_health_logo.png') }}" alt="شعار المديرية">
            <h2>{{ $systemSettings->directorate_name ?? 'مديرية الشئون الصحية بسوهاج' }}  </h2>
            <p>{{ $systemSettings->system_name ?? 'نظام قاعات التدريب' }} </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- البريد الإلكتروني -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- كلمة المرور -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label">كلمة المرور</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- زر الدخول -->
            <button type="submit" class="btn btn-primary mt-2">تسجيل الدخول</button>
        </form>

        <div class="footer-text">
            <hr>
            <p>© {{ date('Y') }} مديرية الشئون الصحية بسوهاج - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>
