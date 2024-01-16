<?php
include("../config/koneksi.php");
// include("../include/API.php");
session_start();
error_reporting(0);
?>
<option value="all">Semua</option>
<?php $q2 = mysqli_query($koneksi, "select *,alamat_kabupaten.id as idd from alamat_kabupaten where provinsi_id = " . $_GET['provinsi_id'] . " order by nama_kabupaten ASC");
while ($row2 = mysqli_fetch_array($q2)) {
?>
    <option value="<?php echo $row2['idd']; ?>"><?php echo $row2['nama_kabupaten']; ?></option>
<?php } ?>