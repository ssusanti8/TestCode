<!DOCTYPE html>
<html>
<head>
	<title>KATALOG</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
 
	<div class="table table-bordered">
		<center>
			<h4>KATALOG</h4>
			<!-- <h5><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">www.malasngoding.com</a></h5> -->
		</center>
		<br/>
		<!-- <a href="/reservasiku/reservasi_pdf" class="btn btn-primary" target="_blank">CETAK PDF</a> -->
		<left>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					{{-- <th>Gambar</th> --}}
					<th>Harga</th>
					<th>Deskripsi</th>
					<th>Stok</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($katalogs as $kata)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$kata->tanggal}}</td>
					{{-- <td class="text-center">
						<img src="{{ Storage::url('public/katalogs/').$kata->gambar }}" class="rounded" style="width: 150px">
					</td> --}}
					{{-- <img src="{{ asset('storage/katalogs/' . $kata->gambar) }}" class="rounded" style="width: 150px"> --}}
					<td>Rp. {{number_format($kata->harga, 0, ',', '.') }}</td>
					<td>{{$kata->deskripsi}}</td>
					<td>{{$kata->stok}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
        </left>
	</div>
 
</body>
</html>