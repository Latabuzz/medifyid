<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kategori {{$kategoriItem->kode}}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .meta td { border: none; padding: 2px 0; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; text-align: right; }
    </style>
</head>
<body>
    <h2>Kategori Item</h2>
    <table class="meta">
        <tr>
            <td style="width: 120px;">Nama kategori</td>
            <td>: {{$kategoriItem->nama}}</td>
        </tr>
        <tr>
            <td>Kode kategori</td>
            <td>: {{$kategoriItem->kode}}</td>
        </tr>
    </table>

    <h3>Daftar Master Items</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Supplier</th>
                <th>Harga</th>
                <th>Laba</th>
                <th>Hargajual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoriItem->masterItems as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->kode}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->supplier}}</td>
                <td>{{$item->harga_beli}}</td>
                <td>{{$item->laba}}</td>
                <td>{{round($item->harga_beli + $item->harga_beli * $item->laba / 100)}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada master item</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{now()->format('d-m-Y H:i:s')}}</div>
</body>
</html>
