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
                        a.id as idd 
                    from
                        pinjaman a left join nasabah b on b.id = a.nasabah_id left join 
                        buku_kas c on c.id = a.buku_kas_id 
                    where b.nik like ('%$_GET[cari]%') 
                        or b.nama_nasabah like ('%$_GET[cari]%') 
                        or c.nama_akun like ('%$_GET[cari]%') 
                        or a.keterangan like ('%$_GET[cari]%') 
                        or a.operator like ('%$_GET[cari]%') 
                    order by a.tgl_pinjam desc, a.id desc LIMIT $start, $limit";
    } else {
        $sql = "select
                        *,
                        COALESCE((select sum(d.angsuran) from pinjaman_bayar d where d.pinjaman_id = a.id), 0) as total_angsuran,
                        (a.nominal_pinjam-COALESCE((select sum(d.angsuran) from pinjaman_bayar d where d.pinjaman_id = a.id),0)) as total_kekurangan,
                        COALESCE((select sum(d.angsuran)+sum(d.bunga) from pinjaman_bayar d where d.pinjaman_id = a.id), 0) as total_angsuran_bunga,
                        COALESCE((select sum(d.bunga) from pinjaman_bayar d where d.pinjaman_id = a.id), 0) as total_keuntungan,
                        a.id as idd 
                    from
                        pinjaman a left join nasabah b on b.id = a.nasabah_id left join 
                        buku_kas c on c.id = a.buku_kas_id 
                    order by a.tgl_pinjam desc, a.id desc LIMIT $start, $limit";
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
        $sql = "select
                        count(a.id) as jml 
                    from
                        pinjaman a left join nasabah b on b.id = a.nasabah_id left join 
                        buku_kas c on c.id = a.buku_kas_id 
                    where b.nik like ('%$_GET[cari]%') 
                        or b.nama_nasabah like ('%$_GET[cari]%') 
                        or c.nama_akun like ('%$_GET[cari]%') 
                        or a.keterangan like ('%$_GET[cari]%') 
                        or a.operator like ('%$_GET[cari]%')";
    } else {
        $sql = "select count(a.id) as jml from pinjaman a";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
