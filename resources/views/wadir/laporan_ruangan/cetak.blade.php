<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Kegiatan</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 font-size: 22px;
 font-weight: bold; 
 padding: 5px 0 6px 0;
 text-align: center;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}
table,th,td { border:1px solid black; border-collapse:collapse; } th,td { padding:5px; }

</style>
</head>
<body>

<h1>Laporan Ruangan Yang Digunakan Dalam Pelaksanaan Kegiatan di </h1>
<h2 style="text-align: center; padding-bottom: 20px">Politeknik Negeri Banyuwangi</h2>

@if (!empty($tahun))
<h3 style="text-align: center">Tahun {{ $tahun }}</h3>
@endif
  
<table width="100%">
	<tr align="center" style="font-size: 19px; font-weight: 900; ">
		<td>Nama Ruangan</td>
		<td>Jumlah Kegiatan</td>
	</tr>

    <?php $no = 1; foreach($data as $value) {  ?>
        <tr>
            <td>{{ $value->nama_ruangan }}</td>
            <td>{{ $value->jml_kegiatan }}</td>
        </tr>
	<?php } ?>
 
</table> 
</body>
</html>