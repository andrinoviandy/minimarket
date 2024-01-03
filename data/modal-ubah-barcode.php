<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *, barang_gudang_detail.id as idd from barang_gudang_detail where id = " . $_GET['id'] . ""));
?>
<form method="post" enctype="multipart/form-data" onsubmit="ubahBarcode(); return false;">
    <div class="modal-body">
        <p align="justify">
            <input type="hidden" name="idd" id="idd" value="<?php echo $data['idd'] ?>" />
            <input type="text" id="qrcode" name="kode_qrcode" class="form-control" value="<?php echo $data['qrcode']; ?>" placeholder="Kode QRCode" />
        </p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="simpan_qrcode"><i class="fa fa-save"></i> Simpan</button>
    </div>
</form>