<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kas RT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2563EB, #38BDF8);
            overflow: hidden;
        }
        body::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: #93C5FD;
            border-radius: 50%;
            top: -180px;
            left: -150px;
            opacity: 0.3;
        }
        body::after {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: #10B981;
            border-radius: 50%;
            bottom: -150px;
            right: -120px;
            opacity: 0.25;
        }
        .container {
            width: 950px;
            height: 560px;
            display: flex;
            background: #ffffff;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }
        .left {
            width: 45%;
            background: linear-gradient(180deg, #3B82F6, #2563EB);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
        }
        .icon-area {
            position: relative;
            width: 250px;
            height: 250px;
            margin-bottom: 30px;
        }
        .circle {
            width: 220px;
            height: 220px;
            background: #60A5FA;
            border-radius: 50%;
            position: absolute;
            left: 15px;
            bottom: 0;
        }
        .money {
            position: absolute;
            font-size: 95px;
            top: 20px;
            left: 80px;
        }
        .house {
            position: absolute;
            font-size: 70px;
            bottom: 60px;
            left: 30px;
        }
        .users {
            position: absolute;
            font-size: 60px;
            bottom: 50px;
            right: 25px;
        }
        .left h2 {
            margin-bottom: 10px;
        }
        .left p {
            text-align: center;
            line-height: 28px;
        }
        .right {
            width: 55%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #2563EB;
        }
        .right > p {
            text-align: center;
            margin-bottom: 25px;
            color: #666666;
        }
        .input {
            margin-bottom: 20px;
        }
        .input input {
            width: 100%;
            padding: 15px;
            border: none;
            border-bottom: 2px solid #dddddd;
            font-size: 15px;
            transition: 0.3s;
        }
        .input input:focus {
            outline: none;
            border-color: #2563EB;
        }
        .alert-danger {
            background-color: #FEE2E2;
            color: #DC2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 15px;
            border: none;
            background: #2563EB;
            color: #ffffff;
            font-size: 17px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #1D4ED8;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            text-decoration: none;
            color: #2563EB;
            font-weight: 600;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="icon-area">
                <div class="circle"></div>
                <i class="fas fa-money-bill-wave money"></i>
                <i class="fas fa-house house"></i>
                <i class="fas fa-users users"></i>
            </div>
            <h2>Sistem Kas RT (Admin)</h2>
            <p>
                Kelola pembayaran kas warga dengan mudah, aman, transparan, dan modern.
            </p>
        </div>
        <div class="right">
            <h1>Selamat Datang Admin</h1>
            <p>Silakan login ke akun pengurus RT</p>

            {{-- Pesan Error Validasi / Login Gagal --}}
            @if ($errors->any())
                <div class="alert-danger">
                    <i class="fas fa-circle-exclamation"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="input">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Email Admin" 
                        value="{{ old('email') }}"
                        required
                    >
                </div>
                <div class="input">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Password" 
                        required
                    >
                </div>

                <button type="submit">
                    <i class="fas fa-right-to-bracket"></i>
                    Login Admin
                </button>

                <div class="footer">
                    Bukan Admin?
                    <a href="{{ route('warga.login') }}">Login Warga (No. KK)</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>