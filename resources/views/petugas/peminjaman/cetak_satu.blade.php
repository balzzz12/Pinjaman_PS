<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pengembalian - {{ $sewa->booking_code }}</title>

    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }

        .container {
            max-width: 420px;
            margin: auto;
            background: white;
            padding: 25px;
            border-top: 6px solid black;
        }

        .header { text-align: center; }

        .row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #ccc;
            margin-bottom: 8px;
            padding-bottom: 5px;
        }

        .booking {
            text-align: center;
            margin-top: 15px;
            border: 2px dashed #aaa;
            padding: 10px;
        }

        .total {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            color: red;
        }

        .no-print { text-align: center; margin-top: 15px; }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>

<body onload="window.print()">

<div class="container">

    <div class="header">
        <h3>STRUK PENGEMBALIAN</h3>
        <small>Rental PlayStation PowerPlay</small>
    </div>

    <div class="row">
        <span>Nama</span>
        <span>{{ $sewa->user->name }}</span>
    </div>

    <div class="row">
        <span>PlayStation</span>
        <span>{{ $sewa->playstation->nama }}</span>
    </div>

    <div class="row">
        <span>Tgl Pinjam</span>
        <span>{{ $sewa->waktu_mulai ?? '-' }}</span>
    </div>

    <div class="row">
        <span>Tgl Kembali</span>
        <span>{{ now()->format('d-m-Y H:i') }}</span>
    </div>

    <div class="row">
        <span>Status</span>
        <span>SELESAI</span>
    </div>

    <div class="row">
        <span>Denda</span>
        <span>Rp {{ number_format($sewa->denda ?? 0, 0, ',', '.') }}</span>
    </div>

    <div class="booking">
        <small>KODE</small><br>
        <strong>{{ $sewa->booking_code }}</strong>
    </div>

    <div class="total">
        Total Bayar: Rp {{ number_format($sewa->denda ?? 0, 0, ',', '.') }}
    </div>

    <p style="text-align:center; font-size:12px; margin-top:15px;">
        Terima kasih 🙏<br>
        Barang sudah dikembalikan
    </p>

</div>

<div class="no-print">
    <button onclick="window.print()">Cetak</button>
</div>

</body>
</html>