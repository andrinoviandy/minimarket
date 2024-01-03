<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<div>
    <button class="btn btn-primary" id="stok_tersedia">Tersedia :
        <?php
        $stok = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok; ?>
    </button>
    <button class="btn btn-default" id="stok_terjual">Terjual :
        <?php
        $stok_terjual = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kirim!=0 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok_terjual ?>
    </button>
    <button class="btn btn-default" id="stok_rusak">Rusak :
        <?php
        $stok_rusak = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kerusakan!=0 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok_rusak; ?>
    </button>
    <button class="btn btn-default" id="stok_tidak_layak">Tidak Layak Jual :
        <?php
        $stok_tl = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kerusakan=2 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok_tl ?>
    </button>
</div>