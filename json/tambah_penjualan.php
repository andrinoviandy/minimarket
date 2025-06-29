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
    if (isset($_GET['status'])) {
        if ($_GET['status'] == '0') {
            if (isset($_GET['cari'])) {
                $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama_produk,
                        b.satuan,
                        (a.harga_jual_saat_itu*a.qty_jual) as sub_total 
                    from
                        penjualan_qty_temp a inner join produk b on b.id = a.produk_id left join produk_detail c on c.id = b.produk_id 
                    where a.status IN ($_GET[status]) and a.akun_id = $_GET[session_id] and (b.nama_produk like ('%$_GET[cari]%') 
                        or c.qrcode like ('%$_GET[cari]%')) 
                    order by a.id desc";
            } else {
                $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama_produk,
                        b.satuan,
                        (a.harga_jual_saat_itu*a.qty_jual) as sub_total 
                    from
                        penjualan_qty_temp a left join produk b on b.id = a.produk_id where a.status IN ($_GET[status]) and a.akun_id = $_GET[session_id] order by a.id desc";
            }
        } else {
            if (isset($_GET['cari'])) {
                $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama as nama_siswa,
                        c.nama as nama_guru,
                        d.banyak_produk 
                    from
                        penjualan a left join smkhilpa_kantin.siswa b on b.id = a.id_siswa left join smkhilpa_kantin.guru c on c.id = a.id_guru left join (select penjualan_id, sum(qty_jual) as banyak_produk from penjualan_qty_temp where status = 1 group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual IN ($_GET[status]) and (a.no_po_jual like ('%$_GET[cari]%') 
                        or b.nama like ('%$_GET[cari]%') 
                        or c.nama like ('%$_GET[cari]%')) 
                    order by a.tgl_jual desc";
            } else {
                $sql = "select
                        a.*,
                        a.id as idd, 
                        b.nama as nama_siswa,
                        c.nama as nama_guru,
                        d.banyak_produk 
                    from
                        penjualan a left join smkhilpa_kantin.siswa b on b.id = a.id_siswa left join smkhilpa_kantin.guru c on c.id = a.id_guru left join (select penjualan_id, sum(qty_jual) as banyak_produk from penjualan_qty_temp where status = 1 group by penjualan_id) d on a.id = d.penjualan_id 
                    where a.status_jual IN ($_GET[status]) order by a.tgl_jual desc";
            }
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
    if (isset($_GET['status'])) {
        if ($_GET['status'] == '0') {
            if (isset($_GET['cari'])) {
                $sql = "select
                            count(a.id) as jml 
                        from
                            penjualan_qty_temp a inner join produk b on b.id = a.produk_id left join produk_detail c on c.id = b.produk_id 
                        where a.status IN ($_GET[status]) and akun_id = $_SESSION[id] and (b.nama_produk like ('%$_GET[cari]%') 
                            or c.qrcode like ('%$_GET[cari]%'))";
            } else {
                $sql = "select count(a.id) as jml from penjualan_qty_temp a inner join produk b on b.id = a.produk_id where a.status IN ($_GET[status]) and akun_id = $_SESSION[id]";
            }
        } else {
            if (isset($_GET['cari'])) {
                $sql = "select
                            count(a.id) as jml 
                        from
                            penjualan a left join smkhilpa_kantin.siswa b on b.id = a.id_siswa left join smkhilpa_kantin.guru c on c.id = a.id_guru  
                        where a.status_jual IN ($_GET[status]) and (a.no_po_jual like ('%$_GET[cari]%') 
                            or b.nama like ('%$_GET[cari]%') 
                            or c.nama like ('%$_GET[cari]%'))";
            } else {
                $sql = "select count(a.id) as jml from penjualan a where a.status_jual IN ($_GET[status])";
            }
        }
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
