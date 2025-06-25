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
                        d.banyak_produk 
                    from
                        penjualan a left join kantin.siswa b on b.id = a.id_siswa left join kantin.guru c on c.id = a.id_guru left join pelanggan p on p.id = a.id_pelanggan left join (select penjualan_id, sum(qty_jual) as banyak_produk from penjualan_qty group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual = 3 and (a.no_po_jual like ('%$_GET[cari]%') 
                        or b.nama like ('%$_GET[cari]%') 
                        or p.nama_pelanggan like ('%$_GET[cari]%') 
                        or c.nama like ('%$_GET[cari]%')) 
                    order by a.tgl_jual desc";
    } else {
        $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama as nama_siswa,
                        c.nama as nama_guru,
                        p.nama_pelanggan as nama_pelanggan,
                        d.total_pembayaran 
                    from
                        penjualan a left join kantin.siswa b on b.id = a.id_siswa left join kantin.guru c on c.id = a.id_guru left join pelanggan p on p.id = a.id_pelanggan left join (select penjualan_id, sum(nominal_pembayaran) as total_pembayaran from piutang group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual  = 3 order by a.tgl_jual desc";
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
                            penjualan a left join kantin.siswa b on b.id = a.id_siswa left join kantin.guru c on c.id = a.id_guru 
                            left join pelanggan p on p.id = a.id_pelanggan 
                        where a.status_jual = 3 and (a.no_po_jual like ('%$_GET[cari]%') 
                            or b.nama like ('%$_GET[cari]%') 
                            or p.nama_pelanggan like ('%$_GET[cari]%') 
                            or c.nama like ('%$_GET[cari]%'))";
    } else {
        $sql = "select count(a.id) as jml from penjualan a where a.status_jual = 3";
    }


    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
