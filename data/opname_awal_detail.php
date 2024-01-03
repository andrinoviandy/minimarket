<?php
error_reporting(0);
include("../config/koneksi.php");
include("../include/API.php");
session_start()
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
    $search = str_replace(" ", "%20", $_GET['cari']);
    $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&id=$_GET[id]");
    $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id=$_GET[id]");
} else {
    $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id=$_GET[id]");
    $file2 = file_get_contents($API . "json/$_GET[page].php?id=$_GET[id]");
}
$json = json_decode($file, true);
$jml = count($json);

$jml2 = $file2;

?>
<div>
    <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
</div>
<div class="table-responsive no-padding" <?php if ($jml2 > 7) { ?> style="height: 300px;" <?php } ?>>
    <table width="100%" id="" class="table table-bordered">
        <thead>
            <tr>
                <th align="center">No</th>
                <th valign="top"><strong>Nama Barang</strong></th>
                <th valign="top">Tipe</th>
                <th valign="top">No Seri</th>
                <th>Qr Code</th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php echo $start += 1; ?></td>
                <td>
                    <?php echo date("d/m/Y", strtotime($json[$i]['nama_brg'])); ?>
                </td>
                <td><?php echo $json[$i]['tipe_brg'] ?></td>
                <td>
                    <?php
                    echo $json[$i]['no_seri_brg']
                    ?>
                </td>
                <td>
                    <?php
                    echo $json[$i]['qrcode'];
                    ?>
                </td>
            </tr>
            
        <?php } ?>
    </table>
</div>