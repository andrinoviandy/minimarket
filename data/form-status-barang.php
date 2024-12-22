<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<form method="post" onsubmit="simpanStatusBarang(); return false;" id="formUpdateStatus">
    <div class="modal-body">
        <input type="hidden" name="id_ubah" value="<?php echo $_GET['id_ubah'] ?>" />
        <input type="hidden" name="id_gudang_detail" value="<?php echo $_GET['id_gudang_detail'] ?>" />
        <select id="input" name="status" class="form-control select2" style="width:100%">
            <?php
            $q3 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_detail where id=" . $_GET['id_gudang_detail'] . ""));
            ?>
            <?php if ($q3['status_kerusakan'] == 0) { ?>
                <option value="1">Barang Rusak & Masih Diperbaiki Teknisi</option>
                <option value="2">Barang Tidak Layak Dijual & Akan Dikembalikan Ke Pabrik</option>
            <?php } ?>
            <?php if ($q3['status_kerusakan'] == 1) { ?>
                <option value="0">Barang Layak Dijual & Kembalikan ke Stok Gudang</option>
                <option value="2">Barang Tidak Layak Dijual & Akan Dikembalikan Ke Pabrik</option>
            <?php } ?>
            <?php if ($q3['status_kerusakan'] == 2) { ?>
                <option value="0">Barang Layak Dijual & Kembalikan ke Stok Gudang</option>
                <option value="1">Barang Rusak & Akan Diperbaiki Teknisi</option>
            <?php } ?>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button name="kirim_barang" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
    </div>
</form>