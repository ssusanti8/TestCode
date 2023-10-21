@extends('layouts.app')

@section('title', __('USER'))

@section('content')
<h6 class="page-head"><center>DATA ADMIN</h6>
<div class="card border-0 shadow rounded">
    <!-- Title -->
    <div class="card body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><center>No</th>
                    <th><center>Nama</th>
                    <th><center>Email</th>
                    <th><center>Status</th>
                    <th><center>Aksi</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $counter = 1;
                    ?>
                @forelse ($users as $user)
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="text-center">
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('userKu.destroy', $user->id) }}" method="POST">
                            <a href="{{ route('userKu.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php
                    $counter++;
                    ?>
                @empty
                <div class="alert alert-danger">
                    Data user belum Tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection