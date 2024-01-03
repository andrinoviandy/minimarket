<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start()
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
    $search = str_replace(" ", "%20", $_GET['cari']);
    $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
    $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
} else {
    $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
    $file2 = file_get_contents($API . "json/$_GET[page].php");
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
                <th valign="top"><strong>Tanggal</strong></th>
                <th valign="top">Keterangan</th>
                <th valign="top">Di Scan</th>
                <th>Ditemukan</th>
                <th>Tidak Ditemukan</th>
                <th>Cetak</th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php echo $start += 1; ?></td>
                <td>
                    <?php echo date("d/m/Y", strtotime($json[$i]['tgl_cek'])); ?>
                </td>
                <td><?php echo $json[$i]['keterangan'] ?></td>
                <td>
                    <?php
                    $ditemukan = mysqli_num_rows(mysqli_query($koneksi, "select * from stok_opname_detail where stok_opname_id = " . $json[$i]['idd'] . ""));
                    $tdk_ditemukan = mysqli_num_rows(mysqli_query($koneksi, "select * from stok_opname_detail_x where stok_opname_id = " . $json[$i]['idd'] . ""));$tdk_ditemukan = mysqli_num_rows(mysqli_query($koneksi, "select * from stok_opname_detail_x where stok_opname_id = " . $json[$i]['idd'] . ""));
                    echo $ditemukan + $tdk_ditemukan;
                    ?>
                </td>
                <td>
                    <?php
                    echo $ditemukan;
                    ?>
                </td>
                <td>
                    <?php
                    echo $tdk_ditemukan;
                    ?>
                </td>
                <td align="center">
                    <a href="?page=opname_awal_detail&id=<?php echo $json[$i]['idd']; ?>">
                        <button class="btn btn-info btn-xs">
                            <span data-toggle="tooltip" title="Detail" class="fa fa-folder-open"></span>
                        </button>
                    </a>
                    <!-- <a href="#" onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                        <button class="btn btn-danger btn-xs">
                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                        </button>
                    </a> -->
                    <a href="cetak_stok_opname.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank">
                        <button class="btn btn-primary btn-xs">
                            <span data-toggle="tooltip" title="Cetak" class="fa fa-print"></span>
                        </button>
                    </a>
                </td>
            </tr>
            
        <?php } ?>
    </table>
</div>