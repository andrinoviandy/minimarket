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
                <th valign="top">#</th>
                <th align="center" valign="top">
                    <table width="100%">
                        <tr>
                            <td>Nama Alkes</td>
                            <td>Tipe Brg</td>
                            <td>No Seri</td>
                        </tr>
                    </table>
                </th>
                <th align="center" valign="top"><strong>Nomor Retur</strong> </th>
                <th align="center" valign="top">Tgl Retur</th>
                <th align="center" valign="top">Nomor PO/ID</th>
                <th align="center" valign="top">Dinas/RS/Dll</th>
                <th align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td><?php echo $start += 1; ?></td>
                <td valign="top">
                    <table width="100%" border="0">
                        <?php
                        $q2 = mysqli_query($koneksi, "select nama_brg,no_seri_brg,tipe_brg,barang_kembali_detail.id as idd from barang_kembali_detail,barang_gudang,barang_gudang_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_kembali_detail.barang_gudang_detail_id and barang_kembali_id=" . $json[$i]['idd'] . "");
                        $n = 0;
                        while ($d1 = mysqli_fetch_array($q2)) {
                            $n++;
                            if ($n % 2 == 0) {
                                $col = "#CCCCCC";
                            } else {
                                $col = "#999999";
                            }
                        ?>
                            <tr bgcolor="<?php echo $col; ?>">
                                <td align="left"><?php echo $d1['nama_brg'] ?></td>
                                <td align="left"><?php echo $d1['tipe_brg'] ?></td>
                                <td align="right"><?php echo $d1['no_seri_brg'];
                                                    $dd = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_kembali_teknisi where barang_kembali_detail_id=" . $d1['idd'] . ""));
                                                    if ($dd) {
                                                        echo " <span class='fa fa-user'></span>";
                                                    }
                                                    ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
                <td><?php echo $json[$i]['no_retur']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_retur'])); ?></td>

                <td><?php echo $json[$i]['no_po_id']; ?></td>
                <td><?php
                    $pemb = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli from barang_kembali,barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim.id=barang_kembali.barang_dikirim_id and barang_kembali.id=" . $json[$i]['idd'] . ""));
                    echo $pemb['nama_pembeli'];
                    ?></td>
                <td align="">
                    <form method="post">
                        <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator'])) { ?>

                            <a href="index.php?page=barang_kembali_teknisi&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a> &nbsp; <?php } ?><!--<a href="index.php?page=ubah_barang_kembali&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>&nbsp; --><a href="cetak_surat_kembali.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank"><span data-toggle="tooltip" title="Cetak Retur Pengembalian" class="fa fa-print"></span></a> &nbsp; <a href="index.php?page=barang_kembali_pilih_teknisi&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Pilih Teknisi" class="label bg-green">Pilih Teknisi</small></a>
                        <!-- Tombol Jual -->


                        <input type="hidden" name="id" value="<?php echo $json[$i]['idd']; ?>" />
                        </a>
                    </form>

                </td>
            </tr>
        <?php } ?>
    </table>
</div>