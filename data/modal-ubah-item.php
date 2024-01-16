<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_detail where id = " . $_GET['id'] . ""));
?>
<form method="post" enctype="multipart/form-data" id="formUbah" onsubmit="ubahItem(); return false;">
    <div class="modal-body">
        <label>No. Bath</label>
        <input type="hidden" name="id_item" id="id_item" value="<?php echo $data['id'] ?>" />
        <input name="no_bath" id="no_bath" class="form-control" type="text" placeholder="" value="<?php echo $data['no_bath']; ?>"><br />
        <label>No. Lot</label>
        <input name="no_lot" id="no_lot" class="form-control" type="text" placeholder="" value="<?php echo $data['no_lot']; ?>"><br />
        <label>No. Seri</label>
        <input name="no_seri" id="no_seri" class="form-control" type="text" placeholder="" value="<?php echo $data['no_seri_brg']; ?>"><br />
        <label>Expired</label>
        <input name="tgl_expired" id="expired" class="form-control" type="date" placeholder="" value="<?php echo $data['tgl_expired']; ?>"><br />
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button name="ubah_detail" type="submit" class="btn btn-warning">Simpan</button>

    </div>
</form>