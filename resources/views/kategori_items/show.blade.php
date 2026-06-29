@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{route('kategori-items.index')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
                <a href="{{route('kategori-items.pdf', $kategoriItem)}}" class="btn btn-success">Download PDF</a>
            </div>
            <div class="card">
                <div class="card-header">Kategori Item</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$kategoriItem->nama}}</td>
                        </tr>
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{$kategoriItem->kode}}</td>
                        </tr>
                    </table>

                    <h4 class="mt-4">Daftar Master Items</h4>
                    <table class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Supplier</th>
                                <th>Harga Beli</th>
                                <th>Laba</th>
                                <th>Harga Jual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoriItem->masterItems as $item)
                            <tr>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->supplier}}</td>
                                <td>{{$item->harga_beli}}</td>
                                <td>{{$item->laba}}</td>
                                <td>{{round($item->harga_beli + $item->harga_beli * $item->laba / 100)}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada master item</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a class="btn btn-info" href="{{route('kategori-items.edit', $kategoriItem)}}">Edit</a>
                    <form action="{{route('kategori-items.destroy', $kategoriItem)}}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
