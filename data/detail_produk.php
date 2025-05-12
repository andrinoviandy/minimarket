<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
    $search = str_replace(" ", "%20", $_GET['cari']);
    $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&id=$_GET[id]&status=$_GET[status]");
    $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id=$_GET[id]&status=$_GET[status]");
} else {
    $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id=$_GET[id]&status=$_GET[status]");
    $file2 = file_get_contents($API . "json/$_GET[page].php?id=$_GET[id]&status=$_GET[status]");
}
$json = json_decode($file, true);
$jml2 = $file2;

?>
<div class="row" style="margin-bottom: 8px;">
    <div class="col-lg-12">
        <em>
            <?php
            if ($_GET['status'] == 'Tersedia') {
                $textJml = 'Tersedia : ';
            } else if ($_GET['status'] == 'Terjual') {
                $textJml = 'Terjual : ';
            } else if ($_GET['status'] == 'Rusak') {
                $textJml = 'Rusak : ';
            } else if ($_GET['status'] == 'Tidak_Layak') {
                $textJml = 'Tidak Layak : ';
            } else {
                $textJml = 'Tersedia : ';
            }
            echo $textJml . $jml2 ?>
        </em>
        <?php if ($_GET['status'] == 'Terjual') { ?>
            <div class="pull-right">
                <div class="label label-danger">&nbsp;</div> Tanggal Keluar Sebelumnya
                <div class="label label-success">&nbsp;</div> Tanggal Keluar Terakhir (Actual)
            </div>
        <?php } ?>
    </div>
</div>
<div class="table-responsive no-padding">
    <table width="100%" id="" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th><strong>Tgl Masuk</strong></th>
                <th>No PO</th>
                <th>Barcode / Qrcode</th>
                <th>Expired</th>
                <?php if ($_GET['status'] == 'Terjual') { ?>
                    <th>Tgl Terjual</th>
                <?php } ?>
                <td align="center"><strong>Aksi</strong></td>
            </tr>
        </thead>
        <?php
        $jml = count($json);
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php echo $start += 1 ?></td>
                <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_masuk'])); ?></td>
                <td><?php echo $json[$i]['no_po']; ?></td>
                <td><?php echo $json[$i]['qrcode']; ?></td>
                <td><?php
                    if ($json[$i]['tgl_expired'] == '0000-00-00' || $json[$i]['tgl_expired'] == '') {
                        echo "-";
                    } else {
                        echo date("d-m-Y", strtotime($json[$i]['tgl_expired']));
                    } ?></td>
                <?php if ($_GET['status'] == 'Terjual') { ?>
                    <td><?php
                        echo "-"
                        ?>
                    </td>
                <?php } ?>
                <td align="center">
                    <?php if ($_GET['status'] == 'Tersedia') {
                    ?>
                        <a href="javascript:void()" onclick="modalUbahItem('<?php echo $json[$i]['idd']; ?>')">
                            <button class="btn btn-warning btn-xs">
                                <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                            </button>
                        </a>&nbsp;
                        <?php if (isset($_SESSION['user_administrator'])) { ?>
                            <!-- <a href="index.php?page=ubah_barang_masuk&id=<?php echo $_GET['id']; ?>&id_hapus=<?php echo $json[$i]['idd']; ?>&id_po=<?php echo $json[$i]['id_po']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                            <a href="javascript:void()" onclick="hapus('<?php echo $json[$i]['idd']; ?>', '<?php echo $json[$i]['id_po']; ?>')">
                                <button class="btn btn-danger btn-xs">
                                    <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                                </button>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <!-- <br />
                    <a href="javascript:void()" onclick="modalUbahBarcode('<?php echo $json[$i]['idd']; ?>');"><small data-toggle="tooltip" title="Buat QRCode" class="label bg-blue" onclick="dataAwal(<?php echo $json[$i]['idd']; ?>)"><span class="fa fa-barcode"></span>&nbsp; Buat QRCode</small></a>
                    <?php if ($json[$i]['qrcode'] != "") { ?>
                        <a href="javascript:void()" onclick="modalCetakBarcode('<?php echo $json[$i]['idd']; ?>')">
                            <small data-toggle="tooltip" title="Cetak QRCode" class="label bg-red"><span class="fa fa-barcode"></span>&nbsp; Cetak QRCode</small></a>
                    <?php } ?> -->
                </td>

            </tr>
        <?php } ?>
    </table>
</div>