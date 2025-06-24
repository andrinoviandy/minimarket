<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<div>
    <button class="btn btn-primary" id="sudah_ada_qrcode" onclick="stok_tersedia(); return false;">Sudah Ada QrCode :
        <?php
        $stok = mysqli_fetch_array(mysqli_query($koneksi, "select sum(stok_masuk) as jml from produk_detail where qrcode is not null and tgl_expired is not null and TIMESTAMPDIFF(DAY, NOW(), tgl_expired) >= 0 and produk_id=" . $_GET['id'] . ""));
        echo $stok['jml'] > 0 ? $stok['jml'] : 0; ?>
    </button>
    <button class="btn btn-default" id="belum_ada_qrcode" onclick="stok_terjual(); return false;">Belum Ada QrCode & Expired :
        <?php
        $stok_terjual = mysqli_fetch_array(mysqli_query($koneksi, "select sum(stok_masuk) as jml from produk_detail where (qrcode is null or tgl_expired is null) and produk_id=" . $_GET['id'] . ""));
        echo $stok_terjual['jml'] > 0 ? $stok_terjual['jml'] : 0 ?>
    </button>
    <button class="btn btn-default" id="kadaluarsa" onclick="stok_kadaluarsa(); return false;">Kadaluarsa :
        <?php
        $stok_expired = mysqli_fetch_array(mysqli_query($koneksi, "select sum(stok_masuk) as jml from produk_detail where TIMESTAMPDIFF(DAY, NOW(), tgl_expired) < 0 and tgl_expired is not null and produk_id=" . $_GET['id'] . ""));
        echo $stok_expired['jml'] > 0 ? $stok_expired['jml'] : 0; ?>
    </button>
</div>

<script>
    function stok_tersedia() {
        $('#sudah_ada_qrcode').prop('class', 'btn btn-primary');
        $('#belum_ada_qrcode').prop('class', 'btn btn-default');
        $('#kadaluarsa').prop('class', 'btn btn-default');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'ada_qrcode')
    }

    function stok_terjual() {
        $('#sudah_ada_qrcode').prop('class', 'btn btn-default');
        $('#belum_ada_qrcode').prop('class', 'btn btn-primary');
        $('#kadaluarsa').prop('class', 'btn btn-default');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'belum_qrcode')
    }

    function stok_kadaluarsa() {
        $('#sudah_ada_qrcode').prop('class', 'btn btn-default');
        $('#belum_ada_qrcode').prop('class', 'btn btn-default');
        $('#kadaluarsa').prop('class', 'btn btn-primary');
        search.value = '';
        loading()
        loadMore(load_flag = 0, key = search.value, status_b = 'kadaluarsa')
    }
</script>