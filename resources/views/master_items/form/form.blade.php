<form method="POST" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required  value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required  value="{{$item->laba ?? ''}}">
    </div>

    @php
        $selectedKategori = old('kategori_items', $method == 'edit' ? $item->kategoriItems->pluck('id')->toArray() : []);
    @endphp
    <div class="form-group">
        <label>Kategori</label>
        <select class="form-control" name="kategori_items[]" multiple>
            @foreach($kategoriItems as $kategoriItem)
            <option value="{{$kategoriItem->id}}" @if(in_array($kategoriItem->id, $selectedKategori)) selected @endif>
                {{$kategoriItem->nama}} ({{$kategoriItem->kode}})
            </option>
            @endforeach
        </select>
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if($selected == 'Umum') selected @endif>Umum</option>
            <option @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <div class="form-group">
        <label>Foto</label>
        @if($method == 'edit' && $item->foto)
        <div class="mb-2">
            <img src="{{$item->foto_url}}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
        </div>
        @endif
        <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
