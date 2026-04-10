<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pengembalian</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 420px;
            margin: auto;
            background: white;
            padding: 25px;
            border-top: 6px solid black;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h3 {
            margin: 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #ccc;
            margin-bottom: 8px;
            padding-bottom: 5px;
            font-size: 14px;
        }

        .status {
            color: green;
            font-weight: bold;
        }

        .booking {
            text-align: center;
            margin-top: 15px;
            border: 2px dashed #aaa;
            padding: 12px;
            border-radius: 6px;
        }

        .thankyou {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            font-size: 14px;
        }

        .note {
            text-align: center;
            font-size: 12px;
            margin-top: 8px;
            color: #555;
        }

        .no-print {
            text-align: center;
            margin-top: 15px;
        }

        button {
            padding: 8px 15px;
            border: none;
            background: black;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #333;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">

@php
use Carbon\Carbon;

$mulai = $sewa->waktu_mulai ? Carbon::parse($sewa->waktu_mulai) : null;
$selesai = $sewa->waktu_selesai 
    ? Carbon::parse($sewa->waktu_selesai) 
    : now();
@endphp

@if($mulai)
    @php
        $durasiMenit = $mulai->diffInMinutes($selesai);
        $jam = floor($durasiMenit / 60);
        $menit = $durasiMenit % 60;
    @endphp

    {{ $jam }} Jam {{ $menit }} Menit
@else
    -
@endif

<div class="container">

    <div class="header">
        <h3>STRUK PENGEMBALIAN</h3>
        <small>Rental PlayStation PowerPlay</small>
    </div>

    <div class="row">
        <span>Nama</span>
        <span>{{ $sewa->user->name ?? '-' }}</span>
    </div>

    <div class="row">
        <span>PlayStation</span>
        <span>{{ $sewa->playstation->nama ?? '-' }}</span>
    </div>

    <div class="row">
        <span>Tgl Pinjam</span>
        <span>{{ $mulai ? $mulai->format('d-m-Y H:i') : '-' }}</span>
    </div>

    <div class="row">
        <span>Tgl Kembali</span>
        <span>{{ $selesai ? $selesai->format('d-m-Y H:i') : '-' }}</span>
    </div>

    <div class="row">
        <span>Status</span>
        <span class="status">✔ SELESAI</span>
    </div>

    <div class="booking">
        <small>DETAIL SEWA</small><br>
        <strong>{{ $sewa->playstation->nama ?? '-' }}</strong><br>

        <small>
            Durasi:
            @if(isset($jam))
                {{ $jam }} Jam {{ $menit }} Menit
            @else
                -
            @endif
        </small>
    </div>

    <div class="thankyou">
        🎮 Terima kasih sudah menyewa PlayStation
    </div>

    <div class="note">
        Kami tunggu kedatangan Anda kembali 🙏<br>
        Semoga puas dengan layanan kami
    </div>

</div>

<div class="no-print">
    <button onclick="window.print()">Cetak</button>
</div>

</body>
</html>
