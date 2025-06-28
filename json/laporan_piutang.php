<?php
// error_reporting(0);
header("Content-type:application/json");
session_start();
//koneksi ke database
require("../config/koneksi.php");
$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$id_pelanggan = '';
$status_jatuh_tempo = '';
$status_lunas = '';
if (isset($_GET['id_pelanggan']) || isset($_GET['status_jatuh_tempo']) || isset($_GET['status_lunas'])) {
    if ($_GET['id_pelanggan'] != 'all') {
        $pel = explode("-", $_GET['id_pelanggan']);
        if ($pel[1] == 'pelanggan') {
            $id_pelanggan = " and a.id_pelanggan = $pel[0]";
        } else if ($pel[1] == 'siswa') {
            $id_pelanggan = " and a.id_siswa = $pel[0]";
        } else if ($pel[1] == 'guru') {
            $id_pelanggan = " and a.id_guru = $pel[0]";
        } else {
            $id_pelanggan = '';
        }
    }
    if ($_GET['status_jatuh_tempo'] != 'all') {
        if ($_GET['status_jatuh_tempo'] == 'belum') {
            $status_jatuh_tempo = " and a.tgl_jatuh_tempo >= CURDATE()";
        } else {
            $status_jatuh_tempo = " and a.tgl_jatuh_tempo < CURDATE()";
        }
    }
    if ($_GET['status_lunas'] != 'all') {
        if ($_GET['status_lunas'] == 'belum') {
            $status_lunas = " and d.total_pembayaran < a.total_harga";
        } else {
            $status_lunas = " and d.total_pembayaran >= a.total_harga";
        }
    }
}
//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {
    $start = mysqli_real_escape_string($koneksi, $_GET['start']);
    if (isset($_GET['cari'])) {
        $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama as nama_siswa,
                        c.nama as nama_guru,
                        p.nama_pelanggan as nama_pelanggan,
                        d.total_pembayaran,
                        CASE WHEN a.tgl_jatuh_tempo < CURDATE() THEN 'Sudah' ELSE 'Belum' END AS jatuh_tempo,
                        sum(a.total_harga) over() as total_harga_all, 
                        sum(d.total_pembayaran) over() as total_pembayaran_all 
                    from
                        penjualan a left join smkhilpa_kantinsiswa b on b.id = a.id_siswa left join smkhilpa_kantinguru c on c.id = a.id_guru left join pelanggan p on p.id = a.id_pelanggan left join (select penjualan_id, sum(qty_jual) as banyak_produk from penjualan_qty group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual = 3 $id_pelanggan $status_jatuh_tempo $status_lunas and (a.no_po_jual like ('%$_GET[cari]%') 
                        or b.nama like ('%$_GET[cari]%') 
                        or p.nama_pelanggan like ('%$_GET[cari]%') 
                        or c.nama like ('%$_GET[cari]%')) 
                    order by a.tgl_jual desc LIMIT $start, $limit";
    } else {
        $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama as nama_siswa,
                        c.nama as nama_guru,
                        p.nama_pelanggan as nama_pelanggan,
                        d.total_pembayaran,
                        CASE WHEN a.tgl_jatuh_tempo < CURDATE() THEN 'Sudah' ELSE 'Belum' END AS jatuh_tempo,
                        sum(a.total_harga) over() as total_harga_all, 
                        sum(d.total_pembayaran) over() as total_pembayaran_all 
                    from
                        penjualan a left join smkhilpa_kantinsiswa b on b.id = a.id_siswa left join smkhilpa_kantinguru c on c.id = a.id_guru left join pelanggan p on p.id = a.id_pelanggan left join (select penjualan_id, sum(nominal_pembayaran) as total_pembayaran from piutang group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual  = 3 $id_pelanggan $status_jatuh_tempo $status_lunas order by a.tgl_jual desc LIMIT $start, $limit";
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
                            penjualan a left join smkhilpa_kantinsiswa b on b.id = a.id_siswa left join smkhilpa_kantinguru c on c.id = a.id_guru 
                            left join pelanggan p on p.id = a.id_pelanggan 
                        where a.status_jual = 3 $id_pelanggan $status_jatuh_tempo $status_lunas and (a.no_po_jual like ('%$_GET[cari]%') 
                            or b.nama like ('%$_GET[cari]%') 
                            or p.nama_pelanggan like ('%$_GET[cari]%') 
                            or c.nama like ('%$_GET[cari]%'))";
    } else {
        $sql = "select count(a.id) as jml from
                        penjualan a left join smkhilpa_kantinsiswa b on b.id = a.id_siswa left join smkhilpa_kantinguru c on c.id = a.id_guru left join pelanggan p on p.id = a.id_pelanggan left join (select penjualan_id, sum(nominal_pembayaran) as total_pembayaran from piutang group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual  = 3 $id_pelanggan $status_jatuh_tempo $status_lunas";
                    // die($sql);
    }


    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
