<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start()
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
    $search = str_replace(" ", "%20", $_GET['cari']);
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    }
} else {
    if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
        $file2 = file_get_contents($API . "json/$_GET[page].php");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
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
    <table width="100%" id="" class="table table-bordered">
        <thead>
            <tr>
                <th align="center" width="2%"><strong>No</strong></th>
                <th width="" valign="top">ID</th>
                <th width="" valign="top"><strong>Tanggal</strong></th>
                <th width="" valign="top">No PO</th>
                <th width="" valign="top">Barang</th>
                <th width="" valign="top">Klien</th>
                <th width="" valign="top"><strong>Deskripsi</strong></th>
                <th width="" valign="top">Nominal</th>
                <th width="" valign="top">Status</th>
                <th width="" align="center" valign="top"><strong>Aksi</strong></th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $i < $jml; $i++) {
        ?>
            <tr>
                <td align="center"><?php echo $start += 1; ?></td>
                <td><?php echo "HU" . $json[$i]['idd']; ?></td>
                <td>
                    <?php echo date("d M Y", strtotime($json[$i]['tgl_input']));  ?><br />
                    <font style="font-size:11px"><?php if ($json[$i]['jatuh_tempo'] != 0000 - 00 - 00) {
                                                        echo "Jatuh Tempo : " . date("d M Y", strtotime($json[$i]['jatuh_tempo']));
                                                    }  ?></font>
                </td>
                <td><?php echo $json[$i]['no_faktur_no_po']; ?></td>
                <td>

                    <a href="#" data-toggle="modal" data-target="#modal-detailhutang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>

                </td>
                <td><?php echo $json[$i]['klien']; ?></td>

                <td><?php echo $json[$i]['deskripsi']; ?></td>
                <td><?php echo "Rp" . number_format($json[$i]['nominal'], 2, ',', '.'); ?>
                    <hr / style="margin:0px; padding:0px">
                    <font style="font-size:10px">
                        <?php
                        $t_b = mysqli_fetch_array(mysqli_query($koneksi, "select sum(nominal) as total from utang_piutang_bayar where utang_piutang_id=" . $json[$i]['idd'] . ""));
                        if ($t_b['total'] == 0) {
                            echo "Belum Ada Pembayaran";
                        } else {
                            echo "Sisa Hutang : Rp" . number_format($json[$i]['nominal'] - $t_b['total'], 2, ',', '.');
                        }
                        ?>
                    </font>
                </td>
                <?php if ($json[$i]['status_lunas'] == 0) {
                    if ($t_b['total'] == 0) {
                        $b = "btn-danger";
                    } else {
                        $b = "btn-warning";
                    }
                } else {
                    $b = "btn-success";
                } ?>
                <td class="<?php echo $b; ?>" align="center">
                    <?php if ($json[$i]['status_lunas'] == 0) {
                        echo "Belum Lunas";
                    } else {
                        echo "Sudah Lunas";
                    } ?>
                </td>
                <td>
                    <?php if ($json[$i]['status_lunas'] == 0) { ?>
                        <!--<a href="index.php?page=utang&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>
                        &nbsp;&nbsp;
                        <a href="index.php?page=ubah_utang&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a>
                        <br />-->
                    <?php } ?>
                    <?php
                    if ($json[$i]['status_lunas'] == 0) { ?>
                        <a href="index.php?page=bayar_utang&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Bayar" class="label bg-green">Bayar</small></a>
                    <?php } else { ?>
                        <a href="index.php?page=bayar_utang&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Riwayat Pembayaran" class="label bg-yellow"> Riwayat Pembayaran </small></a>
                    <?php } ?>
                    <!--&nbsp;<a target="_blank" href="cetak_rekapan_alkes2.php?id=<?php echo $data['idd']; ?>"><span data-toggle="tooltip" title="Print" class="fa fa-print"></span></a>
                        -->
                    <!-- Tombol Jual -->

                </td>
            </tr>
            <div class="modal fade" id="modal-detailhutang<?php echo $json[$i]['idd']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align="center">Detail Barang</h4>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <p align="justify">

                                    <?php
                                    $q2 = mysqli_query($koneksi, "select nama_brg,tipe_brg,qty,status_ke_stok from barang_pesan_detail,barang_gudang,barang_pesan where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_pesan.no_po_pesan='" . $json[$i]['no_faktur_no_po'] . "'");
                                    $n = 0;
                                    while ($d1 = mysqli_fetch_array($q2)) {
                                        $n++;
                                    ?>
                                        <?php echo $n . ". " . $d1['nama_brg'] . "     |    "; ?></td>
                                        <?php echo $d1['tipe_brg'] . "  |  " ?></td>
                                        <?php echo $d1['qty']; ?>

                                        <hr />
                                    <?php } ?>

                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <?php } ?>
    </table>
</div>