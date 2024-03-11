<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<table align="center">
    <tr>
        <td style="padding: 10px" align="center" class="bg-info" colspan="7"><strong>Filter</strong></td>
    <tr>
        <td style="padding: 10px">Provinsi</td>
        <td style="padding: 10px">:</td>
        <td style="padding: 10px" id="valProvinsi">
            <?php
            if ($_GET['provinsi'] && $_GET['provinsi'] != 'all') {
                $prov = mysqli_fetch_array(mysqli_query($koneksi, "select nama_provinsi from alamat_provinsi where id = " . $_GET['provinsi'] . ""));
                echo $prov['nama_provinsi'];
            } else {
                echo "Semua";
            }
            ?>
        </td>
        <td style="padding: 10px" class="bg-info"></td>
        <td style="padding: 10px">RS/Dinas/Dll</td>
        <td style="padding: 10px">:</td>
        <td style="padding: 10px" id="valPembeli">
            <?php
            if ($_GET['pembeli']) {
                $pemb = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli from pembeli where id = " . $_GET['pembeli'] . ""));
                echo $pemb['nama_pembeli'];
            } else {
                echo "Semua";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px">Kabupaten</td>
        <td style="padding: 10px">:</td>
        <td style="padding: 10px" id="valKabupaten">
            <?php
            if ($_GET['kabupaten'] && $_GET['kabupaten'] != 'all') {
                $kabu = mysqli_fetch_array(mysqli_query($koneksi, "select nama_kabupaten from alamat_kabupaten where id = " . $_GET['kabupaten'] . ""));
                echo $kabu['nama_kabupaten'];
            } else {
                echo "Semua";
            }
            ?>
        </td>
        <td style="padding: 10px" class="bg-info"></td>
        <td style="padding: 10px">Alkes</td>
        <td style="padding: 10px">:</td>
        <td style="padding: 10px" id="valAlkes">
            <?php
            if ($_GET['alkes'] == 'all') {
                echo "Semua";
            } else {
                $alkes = mysqli_fetch_array(mysqli_query($koneksi, "select nama_brg from barang_gudang where id = " . $_GET['alkes'] . ""));
                echo $alkes['nama_brg'];
            }
            ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px">Kecamatan</td>
        <td style="padding: 10px">:</td>
        <td style="padding: 10px" id="valKecamatan">
            <?php
            if ($_GET['kecamatan'] && $_GET['kecamatan'] != 'all') {
                $keca = mysqli_fetch_array(mysqli_query($koneksi, "select nama_kecamatan from alamat_kecamatan where id = " . $_GET['kecamatan'] . ""));
                echo $keca['nama_kecamatan'];
            } else {
                echo "Semua";
            }
            ?>
        </td>
        <td style="padding: 10px" class="bg-info"></td>
        <td style="padding: 10px">Tahun</td>
        <td style="padding: 10px">:</td>
        <td style="padding: 10px" id="valTahun"><?php echo $_GET['tahun']; ?></td>
    </tr>
</table>
<br>