<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Detail Transaksi</h2>
        <p>Customer: {{ $user }}</p>
        <p>Toko: {{ $toko }}</p>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Jual Grosir</th>
                <th>Jumlah Barang</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>Rp {{ number_format($item['harga_grosir'], 0, ',', '.') }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total">
        <p>Total Transaksi: Rp {{ number_format(collect($items)->sum('total'), 0, ',', '.') }}</p>
    </div>
</body>
</html>