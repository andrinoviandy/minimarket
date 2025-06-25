<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $start = $_GET['start'];

    if (isset($_GET['cari'])) {
        $search = str_replace(" ", "%20", $_GET['cari']);
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    }
    $json = json_decode($file, true);
    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive p-0">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th valign="top"><strong>Tgl Transaksi</strong></th>
                    <th valign="top">No. Nota</th>
                    <th valign="top" class="text-nowrap"><strong>Nama Pelanggan</strong></th>
                    <th valign="top">Produk</th>
                    <th align="center" valign="top"><strong>Diskon</strong></th>
                    <th align="center" valign="top" class="text-nowrap">Total Piutang</th>
                    <th align="center" valign="top" class="text-nowrap">Total Pembayaran</th>
                    <th align="center" valign="top" class="text-nowrap">Sisa Piutang</th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($json != null || $json != NULL) {
                    $jml = count($json);
                    for ($i = 0; $i < $jml; $i++) {
                        // if ($json[$i]['status_jual'] == 0) {
                        //     $bg = "bg-danger";
                        // } else {
                        //     $bg = "";
                        // }
                ?>
                        <tr class="<?php echo $bg; ?>">
                            <td align="center">
                                <?php echo $start += 1; ?>
                            </td>
                            <td>
                                <?php echo date("d/m/Y", strtotime($json[$i]['tgl_jual'])); ?>
                            </td>
                            <td><?php echo $json[$i]['no_po_jual']; ?></td>
                            <td>
                                <?php
                                if ($json[$i]['nama_siswa'] != '' || $json[$i]['nama_siswa'] != NULL) {
                                    echo $json[$i]['nama_siswa'];
                                }
                                if ($json[$i]['nama_guru'] != '' || $json[$i]['nama_guru'] != NULL) {
                                    echo $json[$i]['nama_guru'];
                                }
                                if ($json[$i]['nama_pelanggan'] != '' || $json[$i]['nama_pelanggan'] != NULL) {
                                    echo $json[$i]['nama_pelanggan'];
                                }
                                ?>
                            </td>
                            <td>
                                <a href="javascript:void();" onclick="modalBarang('<?php echo $json[$i]['idd']; ?>')">
                                    <button class="btn btn-primary btn-xs">
                                        <span class="fa fa-folder-open"></span>
                                    </button>
                                </a>
                                <?php //} 
                                ?>
                            </td>
                            <td><?php echo $json[$i]['diskon_jual'] . "%"; ?></td>
                            <td><?php echo number_format($json[$i]['total_harga'], 0, ',', '.'); ?></td>
                            <td><?php echo number_format($json[$i]['total_pembayaran'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php
                                if ($json[$i]['total_pembayaran'] >= $json[$i]['total_harga']) {
                                    echo "<span class='badge bg-green'>Lunas</span>";
                                } else {
                                    echo number_format($json[$i]['total_harga'] - $json[$i]['total_pembayaran'], 0, ',', '.');
                                }
                                ?>
                            </td>
                            <td align="center">
                                <div class="text-nowrap">

                                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) { ?>
                                        <a onclick="hapus('<?php echo $json[$i]['idd'] ?>')">
                                            <button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-xs">
                                                <i class="ion-android-delete"></i>
                                            </button>
                                        </a>
                                    <?php } ?>
                                    <a href="#" data-toggle="modal" data-target="#modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                                        <button class="btn btn-primary btn-xs">
                                            <span data-toggle="tooltip" title="Cetak" class="fa fa-print">
                                            </span>
                                        </button>
                                    </a>
                                </div>
                                <div class="text-nowrap">
                                    <button class="btn btn-success btn-xs" onclick="modalBayarPiutang('<?php echo $json[$i]['idd']; ?>','<?php echo $json[$i]['no_po_jual']; ?>'); return false;">
                                        <span data-toggle="tooltip" title="Bayar" class="fa fa-receipt">
                                            Bayar
                                        </span>
                                    </button>
                                    <button class="btn btn-xs btn-primary" onclick="modalRiwayat('<?php echo $json[$i]['idd']; ?>'); return false;">Riwayat</button>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Cetak Penjualan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <a href="cetak_struk_penjualan.php?id=<?php echo $json[$i]['idd']; ?>&trx=<?php echo $json[$i]['no_po_jual']; ?>" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Struk</a>
                                        <!-- <a href="cetak_surat_po_pemesanan_dalam_negeri.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Invoice</a> -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td align="center" colspan="11">Tidak Ada Data</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>