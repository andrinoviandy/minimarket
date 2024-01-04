<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<div>
    <button class="btn btn-primary" id="stok_tersedia" onclick="stok_tersedia(); return false;">Tersedia :
        <?php
        $stok = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok; ?>
    </button>
    <button class="btn btn-default" id="stok_terjual" onclick="stok_terjual(); return false;">Terjual :
        <?php
        $stok_terjual = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kirim!=0 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok_terjual ?>
    </button>
    <button class="btn btn-default" id="stok_rusak" onclick="stok_rusak(); return false;">Rusak :
        <?php
        $stok_rusak = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kerusakan!=0 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok_rusak; ?>
    </button>
    <button class="btn btn-default" id="stok_tidak_layak" onclick="stok_tidak_layak(); return false;">Tidak Layak Jual :
        <?php
        $stok_tl = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kerusakan=2 and barang_gudang_id=" . $_GET['id'] . ""));
        echo $stok_tl ?>
    </button>
</div>

<script>
    function stok_tersedia() {
        $('#stok_tersedia').prop('class', 'btn btn-primary');
        $('#stok_terjual').prop('class', 'btn btn-default');
        $('#stok_rusak').prop('class', 'btn btn-default');
        $('#stok_tidak_layak').prop('class', 'btn btn-default');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'Tersedia')
    }

    function stok_terjual() {
        $('#stok_tersedia').prop('class', 'btn btn-default');
        $('#stok_terjual').prop('class', 'btn btn-primary');
        $('#stok_rusak').prop('class', 'btn btn-default');
        $('#stok_tidak_layak').prop('class', 'btn btn-default');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'Terjual')
    }

    function stok_rusak() {
        $('#stok_tersedia').prop('class', 'btn btn-default');
        $('#stok_terjual').prop('class', 'btn btn-default');
        $('#stok_rusak').prop('class', 'btn btn-primary');
        $('#stok_tidak_layak').prop('class', 'btn btn-default');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'Rusak')
    }

    function stok_tidak_layak() {
        $('#stok_tersedia').prop('class', 'btn btn-default');
        $('#stok_terjual').prop('class', 'btn btn-default');
        $('#stok_rusak').prop('class', 'btn btn-default');
        $('#stok_tidak_layak').prop('class', 'btn btn-primary');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'Tidak_Layak')
    }
</script>