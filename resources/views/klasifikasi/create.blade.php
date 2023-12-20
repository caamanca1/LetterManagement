@extends('layouts.template')

@section('content')
    <h3 class="display-10">
        Tambah Data Klasifikasi Surat
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('KlasifikasiSurat.home') }}">Data Klasifikasi Surat</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data Klasifikasi Surat</li>
        </ol>
    </nav>
    <form action="{{ route('KlasifikasiSurat.store') }}" method="post" class="card p-5">

        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Kode Surat </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="letter_code" name="letter_code">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Klasifikasi Surat </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name_type" name="name_type">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah</button>
    </form>
@endsection