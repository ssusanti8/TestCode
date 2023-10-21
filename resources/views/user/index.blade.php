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
                            <b><span data-feather="arrow-left" class="align-text-bottom" style="font-weight: bold;">DASHBOARD Member</span></b>
                        </a>
                            <li class="nav-item"><a class="nav-link" href="{{ ('#') }}">Katalog Member</a></li>
                        @endcan
                        @can('Administrator')
                        <a class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted border-bottom" aria-current="page" href="/dashboard">
                            <b><span data-feather="arrow-left" class="align-text-bottom" style="font-weight: bold;">DASHBOARD Administrator</span></b>
                        </a>
                            <li class="nav-item"><a class="nav-link" href="{{ ('#') }}">Manage Katalog</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ ('/user') }}">Manage Member</a></li>
                        @endcan
            </li>
            
        </ul>
    </div>
</nav>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<!-- Post Content Column -->
<div class="card border-0 shadow rounded">
    <br>
    <div class="card-header text-center">
        <h3>DATA MEMBER & ADMINISTRATOR</h3>
    </div>
    <!-- Title -->
    <div class="card body">
        <br>
        <div class="cardsearch">
            <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                <div class="form-group">
                    <label for="q" class="control-label">{{ __('Cari') }}</label>
                    <input placeholder="{{ __('name') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                </div>
                <input type="submit" value="{{ __('Cari') }}" class="btn btn-secondary">
            </form>
        </div>
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="text-center">
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('user.destroy', $user->id) }}" method="POST">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning">EDIT</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                        </form>
                    </td>
                </tr>
                @empty
                <div class="alert alert-danger">
                    Data user belum Tersedia.
                </div>
                @endforelse
                {{ $users->links() }}
            </tbody>
        </table>
    </div>
</div>