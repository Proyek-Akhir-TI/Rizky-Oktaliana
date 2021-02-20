<?php

if (!function_exists('vdump')) {
    function vdump($var, $is_die = true, $title = null)
    {
        if (empty($title)) {
            $title = '';
        } else {
            $title = '<b>' . $title . '</b>	<br>------------ <br>';
        }

        // Output
        if ($is_die == true) {
            echo '<pre style="background-color: #253238; color: white">';
            echo '================================================================== <br>';
            echo $title;
            die(var_dump($var));
            echo '<br>================================================================== ';
            echo '</pre>';
        } else {
            echo '<pre style="background-color: #253238; color: white">';
            echo '================================================================== <br>';
            echo $title;
            var_dump($var);
            echo '================================================================== ';
            echo '</pre>';
        }

        // exit
    }
}

function status_proker($status)
{
    switch ($status) {
        case '1':
            return 'Belum Dilaksanakan';
            break;
        case '2':
            return 'Sudah Dilaksanakan';
            break;
        case '3':
            return 'Tidak Dilaksanakan';
            break;
            
        default:
            # code...
            break;
    }
}


if (!function_exists('rupiah()')) {
    function rupiah($angka)
    {
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ",";
        return 'Rp. ' . number_format($angka, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan);
    }
}

function month_text($month)
{
    switch ($month) {
        case '01':
            return 'Januari';
            break;
        case '02':
            return 'Februari';
            break;
        case '03':
            return 'Maret';
            break;
        case '04':
            return 'April';
            break;
        case '05':
            return 'Mei';
            break;
        case '06':
            return 'Juni';
            break;
        case '07':
            return 'Juli';
            break;
        case '08':
            return 'Agustus';
            break;
        case '09':
            return 'September';
            break;
        case '10':
            return 'Oktober';
            break;
        case '11':
            return 'November';
            break;
        case '12':
            return 'Desember';
            break;
        
        default:
            # code...
            break;
    }
}

function get_status($id)
{
    switch ($id) {
        case '1':
            return [
                'name' => 'Belum Bayar',
                'color' => 'warning'
            ];
            break;
        case '2':
            return [
                'name' => 'Menunggu Konfirmasi',
                'color' => 'info'
            ];
            break;
        case '3':
            return [
                'name' => 'Berhasil',
                'color' => 'success'
            ];
            break;
        case '4':
            return [
                'name' => 'Gagal/Kadaluarsa',
                'color' => 'danger'
            ];
            break;
        
        default:
            # code...
            break;
    }
}