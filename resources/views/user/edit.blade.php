<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DASHBOARD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
</head>

<body>

<header class="navbar navbar-dark bg-primary">           
              <a class="navbar-brand col-md-6 col-lg-4 me-0 px-3 fs-6" href="#">Selamat Datang {{ auth()->user()->name }}, Anda Berhasil Login</a>
              <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                  <form action="/logout" method="post">
                    @csrf
                    
                    <button type="submit" class="navbar navbar-dark bg-primary"> Logout <span data-feather="log-out" class="align-text-bottom"></span></button>
                  </form>
                </div>
              </div>
            </header>

    <div class="container-fluid">
        <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block  sidebar position-fixed collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                        @can('Member')
                        <a class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted border-bottom" aria-current="page" href="/dashboard">
                            <b><span data-feather="arrow-left" class="align-text-bottom" style="font-weight: bold;">DASHBOARD MEMBER</span></b>
                        </a>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/pengumumanku') }}">Pemberitahuan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/katalogku') }}">Katalog Member</a></li>
                        @endcan
                        @can('Administrator')
                        <a class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted border-bottom" aria-current="page" href="/dashboard">
                            <b><span data-feather="arrow-left" class="align-text-bottom" style="font-weight: bold;"><center>DASHBOARD ADMINISTRATOR</center></span></b>
                        </a>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/pengumuman') }}">Manage Pemberitahuan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/katalog') }}">Manage Katalog</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/filexcels') }}">Manage Excel</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/user') }}">Manage Member</a></li>
                        @endcan
            </li>
            
        </ul>
    </div>
</nav>
            
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<h1 class="h2">Edit Users</h1>
<div class="col-lg-8">
    <!-- Title -->
    <br><br>
    <form action="{{ route('user.update', $user->id) }}" method="post">
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
            <select type="text" class="form-control" required="required" name="role" value="{{ old('role', $user->role) }}">
                <option {{ $user->role == 'Member' ? 'selected' : '' }}>Member</option>
                <option {{ $user->role == 'Administrator' ? 'selected' : '' }}>Administartor</option>            
            </select>
            <br>
        </div>
        <button type="submit" name="edit" class="btn btn-primary float-right">Edit User</button>
    </form><br><br>

</div>
