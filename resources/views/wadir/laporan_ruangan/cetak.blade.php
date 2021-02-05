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
 border-bottom: 1px solid #D0D0D0;
 font-size: 22px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
 text-align: center;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}
table,th,td { border:1px solid black; border-collapse:collapse; } th,td { padding:5px; }

</style>
</head>
<body>

<h1>Laporan kegiatan </h1>
@if (!empty($bulan))
<h3>{{ $bulan }}-{{ $tahun }}</h3>
    
@endif
@if (!empty($ormawa_id))
<p><b>{{ $ormawa->nama }}</b></p>
    
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