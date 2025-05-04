<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
    if (isset($_GET['cari'])) {
        $sql = "select
                        *,
                        nasabah.id as idd 
                    from
                        nasabah 
                    where nik like ('%$_GET[cari]%') 
                        or nama_nasabah like ('%$_GET[cari]%') 
                        or tempat_lahir like ('%$_GET[cari]%') 
                        or alamat like ('%$_GET[cari]%') 
                        or email like ('%$_GET[cari]%') 
                        or no_hp like ('%$_GET[cari]%') 
                    order by nama_nasabah asc LIMIT $start, $limit";
    } else {
        $sql = "select *, nasabah.id as idd from nasabah order by nama_nasabah asc LIMIT $start, $limit";
    }
    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    // untuk jumlah
    if (isset($_GET['cari'])) {
        $sql = "select count(DISTINCT nasabah.id) as jml from
                        nasabah 
                    where nik like ('%$_GET[cari]%') 
                        or nama_nasabah like ('%$_GET[cari]%') 
                        or tempat_lahir like ('%$_GET[cari]%') 
                        or alamat like ('%$_GET[cari]%') 
                        or no_hp like ('%$_GET[cari]%') 
                        or email like ('%$_GET[cari]%')";
    } else {
        $sql = "select count(*) as jml from nasabah";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
