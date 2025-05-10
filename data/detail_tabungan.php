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
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&id=$_GET[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id=$_GET[id]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id=$_GET[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id=$_GET[id]");
    }
} else {
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id=$_GET[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?id=$_GET[id]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id=$_GET[id]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id=$_GET[id]");
    }
}
$json = json_decode($file, true);
$jml = count($json);

$jml2 = $file2;

?>
<div>
    <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
</div>
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="" align="center"><strong>No</strong></th>
                <th width="" valign="top">Tanggal Transaksi</th>
                <th width="" valign="top">Setor</th>
                <th width="" valign="top">Ambil</th>
                <th width="" valign="top">Keterangan</th>
                <th width="" valign="top">Operator</th>
                <!-- <th width="" align="center" valign="top"><strong>Aksi</strong></th> -->
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php echo $start += 1; ?></td>
                <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_transaksi']));  ?></td>
                <td><?php echo $json[$i]['nominal_setor'] !== NULL ? number_format($json[$i]['nominal_setor'], 0, ',', '.') : '-';  ?></td>
                <td><?php echo $json[$i]['nominal_ambil'] !== NULL ? number_format($json[$i]['nominal_ambil'], 0, ',', '.') : '-';  ?></td>
                <td><?php echo $json[$i]['keterangan']; ?></td>
                <td><?php echo $json[$i]['operator']; ?></td>
                <!-- <td>
                    <button class="btn btn-xs btn-info" onclick="editTransaksi('<?php echo $json[$i]['idd']; ?>')"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></button>
                </td> -->
            </tr>
        <?php } ?>
    </table>
</div>