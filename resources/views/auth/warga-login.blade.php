<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Warga - Kas RT</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2563EB, #38BDF8);
            padding: 20px;
        }

        .container {
            width: 950px;
            max-width: 100%;
            min-height: 560px;
            display: flex;
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .2);
        }

        .left {
            width: 45%;
            background: linear-gradient(180deg, #3B82F6, #2563EB);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
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
            color: #666;
        }

        .input {
            margin-bottom: 20px;
        }

        .input label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #333;
        }

        .input input {
            width: 100%;
            padding: 15px;
            border: none;
            border-bottom: 2px solid #ddd;
            font-size: 15px;
        }

        .input input:focus {
            outline: none;
            border-color: #2563EB;
        }

        .alert-danger {
            background: #FEE2E2;
            color: #DC2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .alert-success {
            background: #DCFCE7;
            color: #15803D;
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
            color: white;
            font-size: 17px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #1D4ED8;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            line-height: 28px;
        }

        .footer a {
            text-decoration: none;
            color: #2563EB;
            font-weight: 600;
        }

        @media(max-width: 700px) {
            .container {
                flex-direction: column;
            }

            .left,
            .right {
                width: 100%;
            }

            .left {
                padding: 30px;
            }

            .right {
                padding: 35px 25px;
            }

            .icon-area {
                transform: scale(.7);
                margin-bottom: 0;
            }
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

        <h2>Portal Kas Warga</h2>

        <p>
            Cek tagihan, transparansi penggunaan kas,
            dan bayar iuran RT dengan praktis.
        </p>

    </div>


    <div class="right">

        <h1>Selamat Datang Warga</h1>

        <p>
            Masuk menggunakan Nomor Kartu Keluarga
        </p>


        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif


        @if($errors->any())
            <div class="alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif


        <form action="{{ route('warga.login.post') }}" method="POST">

            @csrf

            <div class="input">

                <label>Nomor Kartu Keluarga (KK)</label>

                <input
                    type="text"
                    name="no_kk"
                    placeholder="16 digit Nomor KK"
                    value="{{ old('no_kk') }}"
                    maxlength="16"
                    inputmode="numeric"
                    required
                    autofocus
                >

            </div>


            <div class="input">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button type="submit">

                <i class="fas fa-right-to-bracket"></i>

                Masuk Portal Warga

            </button>


            <div class="footer">

                Belum punya password?

                <a href="{{ route('warga.register') }}">
                    Daftar Password
                </a>

                <br>

                Pengurus RT?

                <a href="{{ route('admin.login') }}">
                    Login Admin
                </a>
                &nbsp; | &nbsp;

                <a href="{{ route('pengurus.login') }}">Login Pengurus</a>

            </div>

        </form>

    </div>

</div>

</body>

</html>