@extends('layouts.template')

@section('content')
    <h3 class="display-10">
        Data Guru
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home.page') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Guru</li>
        </ol>
    </nav>
    <div class="container mt-3">
        <div class="d-flex justify-content-end">
            <a href="{{ route('userGuru.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <form action="" method="GET" class="form-inline my-2 my-lg-2 d-flex">
            {{-- <input class="form-control w-25 h-25 mr-sm-2" type="date" placeholder="Search" aria-label="Search" name="Date"> --}}
            <input class="form-control w-25 h-25 mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="Date">
            &nbsp;<button class="btn btn-outline-primary my-0 my-sm-10" type="submit">Cari data</button>
            {{-- &nbsp;<button class="btn btn-outline-danger my-0 my-sm-10" type="Reset">Clear</button> --}}
        </form>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($users as $item)
                    @if ($item['role'] == 'guru')
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('userGuru.edit', $item->id)}}" class="btn btn-primary me-3">Edit</a>
                                <form action="{{ route('userGuru.delete', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{-- <div class="d-flex justify-content-end"> --}}
            {{-- jjika data ada atau > 0 --}}
            {{-- @if ( $users->count()) --}}
            {{-- munculkan tampilann pagination --}}
                {{-- {{ $users->links() }}
            @endif
        </div> --}}
    </div>
@endsection