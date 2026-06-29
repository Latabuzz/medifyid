@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{route('kategori-items.index')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">Edit Kategori Item</div>

                <div class="card-body">
                    @include('kategori_items.form', ['action' => route('kategori-items.update', $kategoriItem), 'method' => 'PUT', 'kategoriItem' => $kategoriItem])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
