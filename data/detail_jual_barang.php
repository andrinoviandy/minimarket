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
<div class="table-responsive no-padding">
    <table width="100%" " class=" table table-bordered table-hover">
        <thead>
            <tr>
                <th align="center">No</th>

                <th bgcolor="#99FFCC">Tanggal Kirim</th>
                <th>Nama Paket</th>

                <th>No Pengiriman</th>
                <th>No PO</th>
                <th><strong>Barang<span class="pull pull-right"></span></strong></th>
                <th><strong>Tempat Tujuan</strong></th>
                <th bgcolor="#99FFCC"><strong>Tanggal Sampai</strong></th>

            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
            //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
            //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
        ?>
            <tr>
                <td align="center"><?php echo $i + 1; ?></td>
                <td bgcolor="#99FFCC"><?php echo date("d/M/Y", strtotime($json[$i]['tgl_kirim'])); ?></td>
                <td><?php echo $json[$i]['nama_paket']; ?></td>

                <td><?php echo $json[$i]['no_pengiriman']; ?></td>
                <td><?php echo $json[$i]['no_po_jual']; ?></td>
                <td>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php //echo $json[$i]['idd']; ?>"> -->
                    <a href="javascript:void()" onclick="modalDetailBarang('<?php echo $json[$i]['idd']; ?>')">
                    <small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                </td>
                <td><?php
                    $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli from pembeli,barang_dijual,barang_dikirim where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=" . $json[$i]['idd'] . ""));
                    echo $data3['nama_pembeli']; ?></td>

                <?php
                if ($json[$i]['tgl_sampai'] != 0000 - 00 - 00) {
                    $bg = "#99FFCC";
                } else {
                    $bg = "red";
                }
                ?>
                <td bgcolor=<?php echo $bg; ?>>
                    <?php
                    if ($json[$i]['tgl_sampai'] != 0000 - 00 - 00) {
                        echo date("d/M/Y", strtotime($json[$i]['tgl_sampai']));
                    } else {
                        echo "-";
                    } ?>
                </td>

            </tr>
        <?php } ?>
    </table>
</div>