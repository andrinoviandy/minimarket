<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<div>
    <button class="btn btn-primary" id="stok_tersedia" onclick="stok_tersedia(); return false;">Tersedia :
        <?php
        $stok = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from produk_detail where status_jual=0 and status_rusak=0 and (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) > 0 or tgl_expired = '0000-00-00' or tgl_expired IS NULL) and produk_id=" . $_GET['id'] . ""));
        echo $stok['jml']; ?>
    </button>
    <button class="btn btn-default" id="stok_terjual" onclick="stok_terjual(); return false;">Terjual :
        <?php
        $stok_terjual = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from produk_detail where status_jual=1 and status_rusak=0 and produk_id=" . $_GET['id'] . ""));
        echo $stok_terjual['jml'] ?>
    </button>
    <button class="btn btn-default" id="stok_rusak" onclick="stok_rusak(); return false;">Rusak :
        <?php
        $stok_rusak = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from produk_detail where status_rusak=1 and produk_id=" . $_GET['id'] . ""));
        echo $stok_rusak['jml']; ?>
    </button>
    <button class="btn btn-default" id="stok_tidak_layak" onclick="stok_tidak_layak(); return false;">Kadaluarsa :
        <?php
        $stok_exp = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from produk_detail where (TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 0 and status_jual = 1) and produk_id=" . $_GET['id'] . ""));
        echo $stok_exp['jml'] ?>
    </button>
</div>

<script>
    function stok_tersedia() {
        $('#stok_tersedia').prop('class', 'btn btn-primary');
        $('#stok_terjual').prop('class', 'btn btn-default');
        $('#stok_rusak').prop('class', 'btn btn-default');
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
        loadMore(load_flag = 0, key = search.value, status_b = 'Expired')
    }
</script>