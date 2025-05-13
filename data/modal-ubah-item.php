<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from produk_detail where id = " . $_GET['id'] . ""));
?>
<form method="post" enctype="multipart/form-data" id="formUbah" onsubmit="ubahItem(); return false;">
    <div class="modal-body">
        <input type="hidden" name="id_ubah" value="<?php echo $_GET['id']; ?>">
        <label>Kode Barcode/QrCode</label>
        <input name="qrcode" id="qrcode" class="form-control" type="text" placeholder="" value="<?php echo $data['qrcode']; ?>"><br />
        <label>Expired</label>
        <input name="tgl_expired" id="tgl_expired" class="form-control" type="date" placeholder="" value="<?php echo $data['tgl_expired']; ?>"><br />
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button name="ubah_detail" type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>