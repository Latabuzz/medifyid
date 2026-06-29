@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{route('kategori-items.create')}}" class="btn btn-secondary">+ Kategori Items Baru</a>
            </div>
            <div class="card">
                <div class="card-header">Daftar Kategori Items</div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                    @endif

                    <h4>Filter</h4>
                    <form method="GET" action="{{route('kategori-items.index')}}">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{$nama}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="kode" value="{{$kode}}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-1">Filter</button>
                        <a href="{{route('kategori-items.index')}}" class="btn btn-secondary mt-1">Reset</a>
                    </form>

                    <table class="table table-striped mt-3" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jumlah Item</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoriItems as $kategoriItem)
                            <tr>
                                <td>{{$kategoriItem->kode}}</td>
                                <td>{{$kategoriItem->nama}}</td>
                                <td>{{$kategoriItem->master_items_count}}</td>
                                <td>
                                    <a href="{{route('kategori-items.show', $kategoriItem)}}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{$kategoriItems->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
