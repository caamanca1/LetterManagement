@extends('layouts.template')

@section('content')
@if (Session::get('success'))
    <div class="alert alert-success w-25 p-3 mt-0 mb-0" role="alert">
      <strong>{{ Session::get('success') }}</strong>
    </div>
  @endif
<div class="jumbotron py-4 px-5">
    <h1 class="display-4">
        Selamat Datang, {{ Auth::user()->name }}!
    </h1>
    <hr class="my-4">
    {{-- <p>Aplikasi ini digunakan hanya oleh pegawai / Staff. Digunakan untuk mengelola Surat Tata Usaha.</p> --}}
  @if (Auth::user()->role == "staff")
    <div class="row">
        <div class="col-sm-6 mb-2 mb-sm-0">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Surat Keluar</h5>
              <p class="card-text">{{ count(App\Models\Letter::all()) }}</p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 mb-2 mb-sm-0">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Klasifikasi Surat</h5>
              <p class="card-text">{{ count(App\Models\Letter_type::all()) }}</p>
              {{-- <a href="#" class="btn btn-primary">Lihat</a> --}}
            </div>
          </div>
        </div>
        <div class="col-sm-4 mb-2 mb-sm-0 mt-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Staff Tata Usaha</h5>
                <p class="card-text">{{ count(App\Models\User::where('role', 'staff')->get()) }}</p>
                {{-- <a href="#" class="btn btn-primary">Lihat</a> --}}
              </div>
            </div>
        </div>
        <div class="col-sm-6 mb-2 mb-sm-0 mt-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Guru</h5>
                <p class="card-text">{{ count(App\Models\User::where('role', 'guru')->get()) }}</p>
                {{-- <a href="#" class="btn btn-primary">Lihat</a> --}}
              </div>
            </div>
        </div>
    </div>
  @endif
  @if(Auth::user()->role == 'guru')
  <div class="row">
    <div class="col-sm-6 mb-2 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Surat Masuk</h5>
          <p class="card-text">{{ count(App\Models\Letter::all()) }}</p>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection