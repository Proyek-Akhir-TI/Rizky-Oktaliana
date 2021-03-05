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
 /* border-bottom: 1px solid #D0D0D0; */
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
.tables,
.tables th,
.tables td { border:1px solid black; border-collapse:collapse; font-size: 10px !important } th,td { padding:5px; }

</style>
</head>
<body>

    <table width="100%" style="margin-bottom: 20px">
        <tr>
            <td width="20%" align="right">
                <img src="https://www.poliwangi.ac.id/vendors/uploads/2019/11/kop-300x286.png" width="100">
            </td>
            <td align="center">
                <h1>Daftar Peserta Kegiatan</h1>
                <h3>{{ $nama_kegiatan }} </h3>
            </td>
        </tr>
    </table>
  
<table width="100%" class="tables">
	<tr align="center" style="font-size: 19px; font-weight: 900; ">
        <th>No</th>
        <th>Nama</th>
        <th>NIM</th>
        <th>Email</th>
        <th>Jurusan</th>
    </tr>
     
    <?php $no = 1; foreach($peserta as $value) {   ?>
        <tr>
            <td>{{ $no++ }}.</td> 
            <td>{{ $value->name }}</td> 
            <td>{{ $value->NIM }}</td>
            <td>{{ $value->Email }}</td>
            <td>{{ $value->jurusan }}</td>
        </tr>
	<?php } ?> 
 
</table> 
</body>
</html>