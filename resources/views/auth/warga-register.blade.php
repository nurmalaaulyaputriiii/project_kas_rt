<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Password Warga</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2563eb, #38bdf8);
            padding: 20px;
        }

        .box {
            width: 450px;
            max-width: 100%;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,.2);
        }

        h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .info {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #2563eb;
        }

    </style>
</head>

<body>

<div class="box">

    <h2>Buat Password Warga</h2>

    <p class="subtitle">
        Aktivasi akun Portal Kas Warga
    </p>

    <div class="info">

        <strong>Perhatian:</strong><br>

        Nomor KK harus sudah didaftarkan oleh
        RT/Admin terlebih dahulu.

    </div>


    @if($errors->any())

        <div class="error">

            {{ $errors->first() }}

        </div>

    @endif


    <form action="{{ route('warga.register.post') }}" method="POST">

        @csrf


        <div class="form-group">

            <label>Nomor Kartu Keluarga</label>

            <input
                type="text"
                name="no_kk"
                value="{{ old('no_kk') }}"
                placeholder="16 digit Nomor KK"
                maxlength="16"
                inputmode="numeric"
                required
            >

        </div>


        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Minimal 6 karakter"
                required
            >

        </div>


        <div class="form-group">

            <label>Konfirmasi Password</label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
            >

        </div>


        <button type="submit">

            Buat Password

        </button>

    </form>


    <a
        href="{{ route('warga.login') }}"
        class="back"
    >
        ← Kembali ke Login

    </a>

</div>

</body>

</html>