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
    $file2 = file_get_contents($API . "json/".$_GET['page'].".php");
}
$json = json_decode($file, true);
$jml = count($json);
$jml2 = $file2;

?>
<div>
    <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
</div>
<div class="table-responsive no-padding">
    <table width="100%" id="" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th align="center">#</th>
                <th valign="top"><strong>Nama Aksesoris</strong></th>
                <th valign="top"><strong>Merk</strong></th>
                <th valign="top"><strong>Tipe</strong></th>
                <th valign="top">NIE</th>
                <th align="center" valign="top"><strong>Deskripsi
                    </strong></th>
                <th align="center" valign="top"><strong>Stok</strong></th>
                <th align="center" valign="top"><strong>Stok PO</strong></th>
                <th align="center" valign="top"><strong>Stok Sisa</strong></th>
                <th align="center" valign="top"><strong>Terkirim</strong></th>
                <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
                    <th align="center" valign="top"><strong>Harga Beli
                        </strong></th>
                    <th align="center" valign="top">Harga Jual</th>
                <?php } ?>
                <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['adminpoluar']) or isset($_SESSION['adminpodalam'])) { ?>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                <?php } ?>
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
                    <?php echo $json[$i]['nama_akse']; ?>
                </td>

                <td><?php echo $json[$i]['merk_akse']; ?></td>
                <td><?php echo $json[$i]['tipe_akse']; ?></td>
                <td><?php echo $json[$i]['nie_akse']; ?></td>
                <td align=""><?php echo $json[$i]['deskripsi_akse']; ?></td>

                <td align=""><?php echo $json[$i]['stok_total_akse']; ?></td>
                <td align="">
                    <?php
                    $stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual_akse) as stok_po from aksesoris_jual_qty where aksesoris_id=" . $json[$i]['idd'] . ""));
                    $stok_po2 = mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail,aksesoris_detail,aksesoris_jual_qty where aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and aksesoris_jual_qty.id=aksesoris_kirim_detail.aksesoris_jual_qty_id and aksesoris_jual_qty.aksesoris_id=" . $json[$i]['idd'] . ""));
                    echo $stok_po1['stok_po'] - $stok_po2; ?></td>
                <?php if ($json[$i]['stok_total_akse'] - ($stok_po1['stok_po'] - $stok_po2) <= 0) {
                    $color = "red";
                } else {
                    $color = "";
                } ?>
                <td align="" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['stok_total_akse'] - ($stok_po1['stok_po'] - $stok_po2); ?></td>
                <td align=""><?php echo $stok_po2; ?></td>
                <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan'])) { ?>
                    <td align=""><?php echo "Rp " . number_format($json[$i]['harga_beli_akse'], 2, ',', '.'); ?></td>

                    <td align=""><?php echo "Rp " . number_format($json[$i]['harga_akse'], 2, ',', '.'); ?></td>
                <?php } ?>

                <td align="center">
                    <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator'])) { ?>
                        <!-- <a href="index.php?page=aksesoris&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                        <a onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                            <button class="btn btn-danger btn-xs">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                        <a href="index.php?page=ubah_akse2&id=<?php echo $json[$i]['idd']; ?>">
                            <button class="btn btn-info btn-xs">
                                <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                            </button>
                        </a>
                        <!--<a href="index.php?page=aksesoris&id=<?php echo $json[$i]['idd']; ?>#openPilihan"><small data-toggle="tooltip" title="Jual Alkes" class="label bg-blue">Jual</small></a>-->
                        <!-- Tombol Jual -->
                    <?php } ?>
                    <?php if (isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['adminpoluar']) or isset($_SESSION['adminpodalam'])) { ?>
                        <a href="index.php?page=ubah_akse2&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>&nbsp;
                        <!--<a href="index.php?page=barang_masuk&id=<?php echo $json[$i]['idd']; ?>#openPilihan"><small data-toggle="tooltip" title="Jual Alkes" class="label bg-blue">Jual</small></a>-->

                    <?php } ?>

                    <input type="hidden" name="id" value="<?php echo $json[$i]['idd']; ?>" />
                    </a>
                </td>

            </tr>
        <?php } ?>
    </table>
</div>