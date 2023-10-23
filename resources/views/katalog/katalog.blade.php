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
                <div class="card-header text-center">
                    <h3>Katalog Member</h3>
                </div>
        <div class="row">
            <a href="{{ url('/cetak_pdf') }}" class="btn btn-primary">Download PDF</a>
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col"><center>TANGGAL</center></th>
                                <th scope="col"><center>GAMBAR</center></th>
                                <th scope="col"><center>HARGA</center></th>
                                <th scope="col"><center>DESKRIPSI</center></th>
                                <th scope="col"><center>STOK</center></th>
                            </tr>
                            </thead>
                            <tbody>
                              @forelse ($katalogs as $katalog)
                                <tr>
                                    <td>{{ $katalog->tanggal }}</td>
                                    <td class="text-center">
                                        <img src="{{ Storage::url('public/katalogs/').$katalog->gambar }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>Rp. {{number_format($katalog->harga, 0, ',', '.') }}</td>
                                    <td>{{ $katalog->deskripsi }}</td>
                                    <td>{{ $katalog->stok }}</td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data katalog belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'BERHASIL!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
            
        @endif
    </script>
