<?php
include("../config/koneksi.php");
// include("../include/API.php");
session_start();
error_reporting(0);
?>
<option value="">Pilih Kecamatan</option>
<?php $q3 = mysqli_query($koneksi, "select *,alamat_kecamatan.id as idd from alamat_kecamatan where kabupaten_id = " . $_GET['kabupaten_id'] . " order by nama_kecamatan ASC");
while ($row3 = mysqli_fetch_array($q3)) {
?>
    <option value="<?php echo $row3['idd']; ?>"><?php echo $row3['nama_kecamatan']; ?></option>
<?php } ?>