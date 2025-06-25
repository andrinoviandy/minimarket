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
                        sum(a.pemasukan) over () as total_pemasukan, 
                        sum(a.pengeluaran) over () as total_pengeluaran  
                    from
                        ((select tgl_jual as tgl, no_po_jual as no_transaksi, 'Penjualan Barang' as uraian, total_harga as pemasukan, '-' as pengeluaran from penjualan where status_jual = 2) 
                    union 
                        (select tgl_jual as tgl, no_po_jual as no_transaksi, 'Piutang' as uraian, '-' as pemasukan, total_harga as pengeluaran from penjualan where status_jual = 3) 
                    union 
                        (select tgl_pembayaran as tgl, no_pembayaran as no_transaksi, 'Pembayaran Piutang' as uraian, nominal_pembayaran as pemasukan, '-' as pengeluaran from piutang) 
                    union 
                        (select tgl_po_pesan as tgl, no_po_pesan as no_transaksi, 'Pembelian Barang' as uraian, '-' as pemasukan, total_harga as pengeluaran from pembelian where status_po_batal = 0)) 
                    a where DATE(a.tgl) between '$_GET[tglArus1]' and '$_GET[tglArus2]' and (a.no_transaksi like ('%$_GET[cari]%') 
                        or a.uraian like ('%$_GET[cari]%')) 
                    order by a.tgl desc";
    } else {
        $sql = "select
                        a.* ,
                        sum(a.pemasukan) over () as total_pemasukan, 
                        sum(a.pengeluaran) over () as total_pengeluaran 
                    from
                        ((select tgl_jual as tgl, no_po_jual as no_transaksi, 'Penjualan Barang' as uraian, total_harga as pemasukan, '-' as pengeluaran from penjualan where status_jual = 2) 
                    union 
                        (select tgl_jual as tgl, no_po_jual as no_transaksi, 'Piutang' as uraian, '-' as pemasukan, total_harga as pengeluaran from penjualan where status_jual = 3) 
                    union 
                        (select tgl_pembayaran as tgl, no_pembayaran as no_transaksi, 'Pembayaran Piutang' as uraian, nominal_pembayaran as pemasukan, '-' as pengeluaran from piutang) 
                    union 
                        (select tgl_po_pesan as tgl, no_po_pesan as no_transaksi, 'Pembelian Barang' as uraian, '-' as pemasukan, total_harga as pengeluaran from pembelian where status_po_batal = 0)) 
                    a where DATE(a.tgl) between '$_GET[tglArus1]' and '$_GET[tglArus2]' order by a.tgl desc";
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
                        count(a.no_transaksi) as jml 
                    from
                        ((select tgl_jual as tgl, no_po_jual as no_transaksi, 'Penjualan Barang' as uraian, total_harga as pemasukan, '-' as pengeluaran from penjualan where status_jual = 2) 
                    union 
                        (select tgl_jual as tgl, no_po_jual as no_transaksi, 'Piutang' as uraian, '-' as pemasukan, total_harga as pengeluaran from penjualan where status_jual = 3) 
                    union 
                        (select tgl_pembayaran as tgl, no_pembayaran as no_transaksi, 'Pembayaran Piutang' as uraian, nominal_pembayaran as pemasukan, '-' as pengeluaran from piutang) 
                    union 
                        (select tgl_po_pesan as tgl, no_po_pesan as no_transaksi, 'Pembelian Barang' as uraian, '-' as pemasukan, total_harga as pengeluaran from pembelian where status_po_batal = 0)) 
                    a where DATE(a.tgl) between '$_GET[tglArus1]' and '$_GET[tglArus2]' and (a.no_transaksi like ('%$_GET[cari]%') 
                        or a.uraian like ('%$_GET[cari]%'))";
    } else {
        $sql = "select count(a.no_transaksi) as jml from ((select tgl_jual as tgl, no_po_jual as no_transaksi, 'Penjualan Barang' as uraian, total_harga as pemasukan, '-' as pengeluaran from penjualan where status_jual = 2) 
                    union 
                        (select tgl_jual as tgl, no_po_jual as no_transaksi, 'Piutang' as uraian, '-' as pemasukan, total_harga as pengeluaran from penjualan where status_jual = 3) 
                    union 
                        (select tgl_pembayaran as tgl, no_pembayaran as no_transaksi, 'Pembayaran Piutang' as uraian, nominal_pembayaran as pemasukan, '-' as pengeluaran from piutang) 
                    union 
                        (select tgl_po_pesan as tgl, no_po_pesan as no_transaksi, 'Pembelian Barang' as uraian, '-' as pemasukan, total_harga as pengeluaran from pembelian where status_po_batal = 0)) a where DATE(a.tgl) between '$_GET[tglArus1]' and '$_GET[tglArus2]'";
    }


    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
