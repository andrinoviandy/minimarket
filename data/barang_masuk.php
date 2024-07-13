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
                <th valign="top"><strong>Nama_Alkes</strong></th>
                <th valign="top">Type/Merk</th>
                <th valign="top">Detail_Alkes</th>
                <th>Jenis_Barang</th>
                <td align="center"><strong>Stok PO Pembelian</strong></td>
                <th align="center" valign="top"><strong>Stok_Gudang</strong></th>
                <td align="center"><strong>Stok PO Penjualan</strong></td>
                <th>Stok_Sisa</th>
                <th align="center" valign="top">Terkirim</th>
                <th align="center" valign="top">Rusak</th>
                <th align="center" valign="top">Demo</th>

                <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])  or isset($_SESSION['user_manajer_keuangan']) && isset($_SESSION['pass_manajer_keuangan'])) { ?>
                    <th align="center" valign="top"><strong>Harga_Beli
                        </strong></th>
                    <th align="center" valign="top"><strong>Harga_Jual
                        </strong></th>
                <?php } ?>
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
                    <?php echo $json[$i]['kategori_brg']; ?>
                </td>
                <td>
                    <?php echo $json[$i]['nama_brg']; ?>
                </td>
                <td><?php echo $json[$i]['tipe_brg'] . " / " . $json[$i]['merk_brg']; ?></td>

                <td>
                    <?php if ($_GET['tampil'] == 1) { ?>
                        <?php echo "[" . $json[$i]['nie_brg'] . "]-[" . $json[$i]['negara_asal'] . "]"; ?>
                        <hr style="margin:0px; border-top:1px double; width:100%" />
                    <?php } else { ?>
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php //echo $json[$i]['idd']; ?>"> -->
                        <a href="javascript:void();" onclick="modalDetailBarang('<?php echo $json[$i]['idd']; ?>');">
                        <small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                    <?php } ?>
                </td>
                <td>
                    <?php
                    if ($json[$i]['jenis_barang'] == 1) {
                        echo "E-Katalog";
                    }
                    ?>
                </td>
                <td align="center"><?php
                                    $stok_beli = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty) as jml from barang_pesan_detail where barang_gudang_id=" . $json[$i]['idd'] . " and status_ke_stok = 0"));
                                    echo $stok_beli['jml']; ?></td>
                <td align="center"><?php
                                    $stok_gudang = 0;
                                    if ($json[$i]['kategori_brg']=='Set') {
                                        $stok_gudang = $json[$i]['stok_total'];
                                    } else {
                                        $stok_total = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_gudang_detail where status_kirim=0 and status_kerusakan=0 and status_kembali_ke_gudang=0 and barang_gudang_id=" . $json[$i]['idd'] . ""));
                                        $stok_gudang = $stok_total['jml'];
                                    }
                                    echo $stok_gudang;
                                    ?>
                                    </td>
                <td align="center"><?php
                                    $stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=" . $json[$i]['idd'] . ""));
                                    $stok_po11 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(jml_total) as stok_po from barang_dijual_qty_detail where barang_gudang_id=" . $json[$i]['idd'] . ""));
                                    $stok_po2 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_gudang_detail.barang_gudang_id=" . $json[$i]['idd'] . ""));
                                    $stok_po = $stok_po1['stok_po'] + $stok_po11['stok_po'] - $stok_po2['jml'];
                                    if ($stok_po != 0) {
                                        echo $stok_po;
                                    }
                                    ?>
                    <?php if ($stok_gudang - ($stok_po) <= 0) {
                        $color = "red";
                    } else {
                        $color = "";
                    } ?>
                </td>

                <td style="background-color:<?php echo $color; ?>"><?php
                                                                    echo $stok_gudang - ($stok_po);
                                                                    ?></td>
                <td align="center"><?php
                                    $cek_stok1 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_gudang_detail where status_kirim=1 and barang_gudang_id=" . $json[$i]['idd'] . ""));
                                    if ($cek_stok1['jml'] != 0) {
                                        echo $cek_stok1['jml'];
                                    } else {
                                        echo "-";
                                    } ?></td>
                <td align="center">
                    <?php
                    $cek_stok2 = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_gudang_detail where status_kerusakan=1 and barang_gudang_id=" . $json[$i]['idd'] . ""));
                    if ($cek_stok2['jml'] != 0) {
                        echo $cek_stok2['jml'];
                    } else {
                        echo "-";
                    } ?>
                </td>
                <td align="center"><?php
                                    $cek_stok_demo = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty) as total_demo from barang_demo_qty where barang_gudang_id=" . $json[$i]['idd'] . ""));
                                    $cek_stok_kembali = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_demo_kirim_detail,barang_gudang_detail,barang_demo_kembali where barang_demo_kirim_detail.id=barang_demo_kembali.barang_demo_kirim_detail_id and barang_gudang_detail.id=barang_demo_kirim_detail.barang_gudang_detail_id and barang_gudang_id=" . $json[$i]['idd'] . ""));
                                    if ($cek_stok_demo['total_demo'] - $cek_stok_kembali['jml'] != 0) {
                                        echo $cek_stok_demo['total_demo'] - $cek_stok_kembali['jml'];
                                    } else {
                                        echo "-";
                                    } ?></td>

                <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan']) or isset($_SESSION['user_manajer_keuangan']) && isset($_SESSION['pass_manajer_keuangan'])) { ?>
                    <td align="center"><?php echo "Rp " . number_format($json[$i]['harga_beli'], 0, ',', '.') . ",-"; ?></td>
                    <td align="center"><?php echo "Rp " . number_format($json[$i]['harga_satuan'], 0, ',', '.') . ",-"; ?></td>
                <?php } ?>

                <td align="center">
                    <?php if (isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
                        <?php if ($json[$i]['kategori_brg'] !== 'Set') { ?>
                            <a href="index.php?page=ubah_barang_masuk&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="index.php?page=ubah_barang_set&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator'])) { ?>
                        <?php if ($json[$i]['kategori_brg'] !== 'Set') { ?>
                            <?php if ($json[$i]['kategori_brg'] == 'Satuan') { ?>
                                <a href="index.php?page=simpan_tambah_aksesoris&id=<?php echo $json[$i]['idd']; ?>">
                                    <small data-toggle="tooltip" title="Kelola Aksesoris" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp; Akse</small>
                                </a>
                            <?php } ?>
                            <a href="index.php?page=simpan_tambah_spesifikasi&id=<?php echo $json[$i]['idd']; ?>">
                                <small data-toggle="tooltip" title="Kelola Spesifikasi" class="label bg-blue"><span class="fa fa-cogs"></span>&nbsp; Spes</small>
                            </a>
                        <?php } ?>
                        <a href="cetak_rekapan_alkes.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank">
                            <small data-toggle="tooltip" title="Rekap Alkes" class="label bg-yellow"><i class="fa fa-print"></i> Excel</small>
                        </a>
                        <br />
                        <a href="#" onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                            <button class="btn btn-danger btn-xs">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                        <?php if ($json[$i]['kategori_brg'] !== 'Set') { ?>
                            <a href="index.php?page=ubah_barang_masuk&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="index.php?page=ubah_barang_set&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($_SESSION['user_admin_gudang']) && isset($_SESSION['pass_admin_gudang'])) { ?>
                        <?php if ($json[$i]['kategori_brg'] == 'Satuan') { ?>
                            <a href="index.php?page=simpan_tambah_aksesoris&id=<?php echo $data['idd']; ?>">
                                <small data-toggle="tooltip" title="Kelola Aksesoris" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp; Akse</small>
                            </a>
                        <?php } ?>
                        <?php if ($json[$i]['kategori_brg'] !== 'Set') { ?>
                            <a href="index.php?page=simpan_tambah_spesifikasi&id=<?php echo $json[$i]['idd']; ?>">
                                <small data-toggle="tooltip" title="Kelola Spesifikasi" class="label bg-blue"><span class="fa fa-cogs"></span>&nbsp; Spes</small>
                            </a>
                        <?php } ?>
                        <a href="cetak_rekapan_alkes.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank">
                            <small data-toggle="tooltip" title="Rekap Alkes" class="label bg-yellow"><i class="fa fa-print"></i> Excel</small>
                        </a>
                        <br />
                        <?php if ($json[$i]['kategori_brg'] !== 'Set') { ?>
                            <a href="index.php?page=ubah_barang_masuk&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="index.php?page=ubah_barang_set&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php
                    if (isset($_SESSION['adminpoluar']) or isset($_SESSION['adminpodalam']) or isset($_SESSION['adminpjt'])) { ?>
                        <?php if ($json[$i]['kategori_brg'] !== 'Set') { ?>
                            <a href="index.php?page=ubah_barang_masuk&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="index.php?page=ubah_barang_set&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>