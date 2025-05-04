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
    if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select
                        deposit.*,
                        deposit.id as idd,
                        bk1.nama_akun as dari_akun,
                        bk2.nama_akun as ke_akun
                    from
                        deposit left join buku_kas bk1 on bk1.id = deposit.dari_akun_id 
                        left join buku_kas bk2 on bk2.id = deposit.ke_akun_id 
                    where tgl_deposit between '$_GET[tgl1]' and '$_GET[tgl2]' and (deposit.deskripsi like ('%$_GET[cari]%') 
                        or bk1.nama_akun like ('%$_GET[cari]%') 
                        or bk2.nama_akun like ('%$_GET[cari]%')) 
                    order by
                        tgl_deposit desc,
                        deposit.id desc LIMIT $start, $limit";
        } else {
            $sql = "select
                        deposit.*,
                        deposit.id as idd,
                        bk1.nama_akun as dari_akun,
                        bk2.nama_akun as ke_akun
                    from
                        deposit left join buku_kas bk1 on bk1.id = deposit.dari_akun_id 
                        left join buku_kas bk2 on bk2.id = deposit.ke_akun_id 
                    where tgl_deposit between '$_GET[tgl1]' and '$_GET[tgl2]' 
                    order by
                        tgl_deposit desc,
                        deposit.id desc LIMIT $start, $limit";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select
                        deposit.*,
                        deposit.id as idd,
                        bk1.nama_akun as dari_akun,
                        bk2.nama_akun as ke_akun
                    from
                        deposit left join buku_kas bk1 on bk1.id = deposit.dari_akun_id 
                        left join buku_kas bk2 on bk2.id = deposit.ke_akun_id 
                    where deposit.deskripsi like ('%$_GET[cari]%') 
                        or bk1.nama_akun like ('%$_GET[cari]%') 
                        or bk2.nama_akun like ('%$_GET[cari]%') 
                    order by
                        tgl_deposit desc,
                        deposit.id desc LIMIT $start, $limit";
        } else {
            $sql = "select
                        deposit.*,
                        deposit.id as idd,
                        bk1.nama_akun as dari_akun,
                        bk2.nama_akun as ke_akun
                    from
                        deposit left join buku_kas bk1 on bk1.id = deposit.dari_akun_id 
                        left join buku_kas bk2 on bk2.id = deposit.ke_akun_id 
                    order by
                        tgl_deposit desc,
                        deposit.id desc LIMIT $start, $limit";
        }
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
    if (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
        if (isset($_GET['cari'])) {
            $sql = "select count(DISTINCT deposit.id) as jml from
                        deposit left join buku_kas bk1 on bk1.id = deposit.dari_akun_id 
                        left join buku_kas bk2 on bk2.id = deposit.ke_akun_id
                    where tgl_deposit between '$_GET[tgl1]' and '$_GET[tgl2]' and (deposit.deskripsi like ('%$_GET[cari]%') 
                        or bk1.nama_akun like ('%$_GET[cari]%') 
                        or bk2.nama_akun like ('%$_GET[cari]%'))";
        } else {
            $sql = "select count(*) as jml from
                        deposit where tgl_deposit between '$_GET[tgl1]' and '$_GET[tgl2]'";
        }
    } else {
        if (isset($_GET['cari'])) {
            $sql = "select count(DISTINCT deposit.id) as jml from
                        deposit left join buku_kas bk1 on bk1.id = deposit.dari_akun_id 
                        left join buku_kas bk2 on bk2.id = deposit.ke_akun_id 
                    where deposit.deskripsi like ('%$_GET[cari]%') 
                        or bk1.nama_akun like ('%$_GET[cari]%') 
                        or bk2.nama_akun like ('%$_GET[cari]%') 
                    order by
                        tgl_deposit desc,
                        deposit.id desc";
        } else {
            $sql = "select count(*) as jml from deposit";
        }
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
