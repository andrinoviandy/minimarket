<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from status_po where pembelian_id = " . $_GET['id'] . ""));
?>
<form method="post" enctype="multipart/form-data" id="formUbah" onsubmit="ubahStatus(); return false;">
    <div class="modal-body">
        <input type="hidden" name="id_ubah" value="<?php echo $_GET['id']; ?>">
        <label>Status</label>
        <select name="status" id="status" required class="form-control select2" style="width: 100%;" onchange="displayStok(this.value);">
            <option <?php if ($_GET['status'] == 0) {echo "selected";} ?> value="0">Belum Masuk Stok</option>
            <option <?php if ($_GET['status'] == 1) {echo "selected";} ?> value="1">Sudah Masuk Stok</option>
        </select>
        <div style="display: none;" id="stokMasuk">
            <br>
            <label>Deskripsi</label>
            <textarea rows="5" class="form-control" name="deskripsi" id="deskripsi" required></textarea>
            <!-- <label>Tgl Expired Produk</label>
            <input type="date" class="form-control" name="tgl_expired" id="tgl_expired" />
            <br>
            <label>QrCode / BarCode</label>
            <input type="text" class="form-control" name="qrcode" id="qrcode" /> -->
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button name="ubah_detail" type="submit" class="btn btn-info">Update Status</button>
    </div>
</form>

<script>
    function displayStok(params) {
        if (params == 1) {
            $('#stokMasuk').css('display', 'block')
        } else {
            $('#stokMasuk').css('display', 'none')
        }
    }
</script>