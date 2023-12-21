@extends('layouts.template')

@section('content')
    <h3 class="display-10">
        Tambah Data Surat
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('dataSurat.home') }}">Data Surat</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data Surat</li>
        </ol>
    </nav>
    <form action="{{ route('dataSurat.store') }}" method="post" class="card p-5">

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
            <label for="letter_perihal" class="col-sm-2 col-form-label">Perihal</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="letter_perihal" name="letter_perihal">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="name_type" class="col-sm-2 col-form-label">Klasifikasi Surat: </label>
            <div class="col-sm-10">
                <select name="letter_type_id" id="klasifikasi" class="form-select">
                    @foreach ($letter as $type)
                        <option value="{{ $type->id }}">{{ $type->name_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="letter_perihal" class="col-sm-2 col-form-label">Isi Surat</label>
            <div class="col-sm-10">
                <textarea name="content" id="" class="form-control"></textarea>              
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <tr>
                <th>Nama</th>
                <th>Peserta (Checklist Jika Ya)</th>
            </tr>
            @foreach ($user as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckChecked" name="recipients[]">
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="mb-3">
            <label for="formFile" class="form-label">Lampiran</label>
            <input class="form-control" type="file" id="formFile" name="attachment">
        </div>
        <div class="mb-3">
            <label for="klasifikasi" class="form-label">Notulis</label>
            <select class="form-select" name="notulis" id="klasifikasi">
                @foreach ($user as $i)
                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah</button>
    </form>
@endsection