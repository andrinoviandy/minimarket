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
<div class="table-responsive no-padding">
    <table width="100%" id="" class="table table-bordered">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Kategori</th>
                <th valign="top" class="text-nowrap"><strong>Nama Produk</strong></th>
                <th>Satuan</th>
                <th valign="top" class="text-nowrap">Harga Beli</th>
                <th valign="top" class="text-nowrap">Harga Jual</th>
                <th align="center" valign="top">Stok Belum Ada QrCode</th>
                <th align="center" valign="top">Stok Gudang</th>
                <th align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php
                                    echo $start += 1;
                                    ?></td>
                <td>
                    <?php echo $json[$i]['kategori']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['nama_produk']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['satuan']; ?>
                </td>
                <td><?php echo "Rp " . number_format($json[$i]['harga_beli'], 0, ',', '.') . ",-"; ?></td>
                <td><?php echo "Rp " . number_format($json[$i]['harga_jual'], 0, ',', '.') . ",-"; ?></td>
                <td><?php echo $json[$i]['stok_belum_qrcode']; ?></td>
                <td><?php echo $json[$i]['stok']; ?></td>
                <td>
                    <a href="index.php?page=detail_produk&id=<?php echo $json[$i]['idd']; ?>">
                        <button class="btn btn-info btn-xs">
                            <span data-toggle="tooltip" title="Detail" class="fa fa-folder-open"></span>
                        </button>
                    </a>
                    <!-- &nbsp;
                    <a href="#" onclick="hapus(<?php echo $json[$i]['idd']; ?>, '<?php echo $json[$i]['nama_produk']; ?>')">
                        <button class="btn btn-danger btn-xs">
                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                        </button>
                    </a> -->
                </td>
            </tr>
        <?php } ?>
    </table>
</div>