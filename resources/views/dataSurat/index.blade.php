@extends('layouts.template')

@section('content')
    @if (Session::get('deleted'))
        <div class="alert alert-success w-25 p-3 mt-0 mb-0" role="alert">
            <strong>{{ Session::get('deleted') }}</strong>
        </div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success w-25 p-3 mt-0 mb-0" role="alert">
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif
    <h3 class="display-10">
        Data Surat
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Data Surat</li>
        </ol>
    </nav>
    <div class="container mt-3">
        <div class="d-flex justify-content-end">
            <a href="{{ route('dataSurat.create') }}" class="btn btn-primary me-2">Tambah Data</a>
            <a href="{{ route('export-excel.export') }}" class="btn btn-info me-2">Export Data Surat</a>
        </div>

        <form action="" method="GET" class="form-inline my-2 my-lg-2 d-flex">
            {{-- <input class="form-control w-25 h-25 mr-sm-2" type="date" placeholder="Search" aria-label="Search" name="Date"> --}}
            <input class="form-control w-25 h-25 mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="Search">
            &nbsp;<button class="btn btn-outline-primary my-0 my-sm-10" type="submit">Cari data</button>
            {{-- &nbsp;<button class="btn btn-outline-danger my-0 my-sm-10" type="Reset">Clear</button> --}}
        </form>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nomor Surat</th>
                    <th>Perihal</th>
                    <th>Tanggal Keluar</th>
                    <th>Penerima Surat</th>
                    <th>Notulis</th>
                    <th>Hasil Rapat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @if(Auth::check())
                @foreach ($letter as $item)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>@if(isset($item['letter_type_id']))
                                {{ $item->LetterType->letter_code }}/000{{ $item->letter_type_id }}/SMK Wikrama/{{ $item['created_at']->format('Y') }}
                                @else
                                    No Notulis Assigned
                                @endif
                            </td>
                            <td>{{ $item->letter_perihal }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>{{ implode(', ', array_column($item->recipients, 'name')) }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                @if (Auth::check())
                                    @if(App\Models\Result::where('letter_id', $item->id)->exists())
                                        <a href="{{ route('result.show', $item->id) }}" style="color: limegreen">Sudah Dibuat</a>
                                        @else
                                        @if(Auth::user()->name == $item->user->name)
                                        @if(Auth::user()->role == 'guru')
                                          <a href="{{ route('result.results', $item->id) }}"><button class="btn btn-warning shadow-none">Buat Hasil</button></a>  
                                        @endif
                                        @else
                                        <a href="#" style="color: red">Belum Dibuat</a>
                                        @endif
                                        @endif
                                    @else
                                @endif
                            </td>
                            @if(Auth::user()->role == 'staff')
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('dataSurat.print', $item->id) }}" class="btn btn-info me-3">Lihat</a>
                                <a href="{{ route('dataSurat.edit', $item->id)}}" class="btn btn-primary me-3">Edit</a>
                                <form action="{{ route('dataSurat.delete', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        {{-- <div class="d-flex justify-content-end">
            @if ( $users->count())
                {{ $users->links() }}
            @endif
        </div> --}}
    </div>
@endsection