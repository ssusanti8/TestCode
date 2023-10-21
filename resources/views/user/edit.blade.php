@extends('layouts.app')

@section('title', __('USER'))

@section('content')
<h6 class="page-head"><center>EDIT STATUS ADMIN</h6>
    <form action="{{ route('userKu.update', $user->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" readonly name="name" value="{{ old('name', $user->name) }}"></br>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" readonly name="email" value="{{ old('email', $user->email) }}"></br>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" readonly name="password" value="{{ old('password', $user->password) }}"></br>
        </div>
        <div class="form-group">
            <label for="levels">Level</label>
            <select type="text" class="form-control @error('role') is-invalid @enderror" required="required" name="role" value="{{ old('role',  $user->role) }}">
                <option {{ $user->role == 'Member' ? 'selected' : '' }}>Member</option>
                <option {{ $user->role == 'Administrator' ? 'selected' : '' }}>Administrator</option>            
            </select>
            <br>
        </div>
        <button type="submit" name="edit" class="btn btn-primary float-right">Edit User</button>
    </form><br><br>

</div>
@endsection
