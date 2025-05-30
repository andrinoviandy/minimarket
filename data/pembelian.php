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
                    <th valign="top"><strong>Tgl PO</strong></th>
                    <th valign="top">No PO</th>
                    <th valign="top"><strong>Supplier</strong></th>
                    <th valign="top" class="text-nowrap"><strong>Alamat Supplier</strong></th>
                    <th valign="top">Produk</th>
                    <th align="center" valign="top"><strong>PPN</strong></th>
                    <th align="center" valign="top" class="text-nowrap"><strong>Cara Pembayaran</strong></th>
                    <th align="center" valign="top" class="text-nowrap">Total Harga</th>
                    <th align="center" valign="top" class="text-nowrap">Total Harga + PPN</th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jml = count($json);
                for ($i = 0; $i < $jml; $i++) {

                    if ($json[$i]['status_po_batal'] == 1) {
                        $bg = "bg-danger";
                    } else {
                        $bg = "";
                    }
                ?>
                    <tr class="<?php echo $bg; ?>">
                        <td align="center">
                            <?php echo $start += 1; ?>
                        </td>
                        <td>
                            <?php echo date("d/m/Y", strtotime($json[$i]['tgl_po_pesan'])); ?>
                        </td>
                        <td><?php echo $json[$i]['no_po_pesan']; ?></td>
                        <td><?php echo $json[$i]['nama_supplier']; ?></td>
                        <td><?php echo $json[$i]['alamat_supplier']; ?></td>
                        <td>
                            <a href="javascript:void();" onclick="modalBarang('<?php echo $json[$i]['idd']; ?>')">
                                <button class="btn btn-primary btn-xs">
                                    <span class="fa fa-folder-open"></span>
                                </button>
                            </a>
                            <?php //} 
                            ?>
                        </td>
                        <td><?php echo $json[$i]['ppn'] . "%"; ?></td>
                        <td><?php echo $json[$i]['cara_pembayaran']; ?></td>
                        <td><?php echo number_format($json[$i]['total_harga'], 0, ',', '.'); ?></td>
                        <td><?php echo number_format($json[$i]['total_harga_ppn'], 0, ',', '.'); ?></td>
                        <td align="center">
                            <?php if ($json[$i]['status_po_batal'] == 0) { ?>
                                <?php if (isset($_SESSION['pass_administrator']) && $json[$i]['status_lunas'] == 0) { ?>
                                    <a onclick="hapus(<?php echo $json[$i]['idd'] ?>)">
                                        <button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-xs">
                                            <i class="ion-android-delete"></i>
                                        </button>
                                    </a><?php } ?>
                                <?php
                                if ($json[$i]['status_lunas'] == 0) {
                                ?>
                                    <a href="index.php?page=ubah_pembelian&id=<?php echo $json[$i]['idd']; ?>">
                                        <button class="btn btn-warning btn-xs">
                                            <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
                                        </button>
                                    </a>
                                <?php } ?>
                                <a href="#" data-toggle="modal" data-target="#modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                                    <button class="btn btn-primary btn-xs">
                                        <span data-toggle="tooltip" title="Cetak" class="fa fa-print">
                                        </span>
                                    </button>
                                </a>

                            <?php
                            } else { ?>
                                <!-- <a href="index.php?page=pembelian_alkes&id_pulih=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda yakin akan memulihkan PO ini ?')"> -->
                                <a onclick="pulihkan(<?php echo $json[$i]['idd']; ?>)" href="#">
                                    <small data-toggle="tooltip" title="Pulihkan PO" class="btn btn-success btn-xs">Pulihkan PO</small>
                                </a>
                                <?php if ($json[$i]['deskripsi_batal'] != '') {
                                ?><br />
                                    <a href="#" data-toggle="modal" data-target="#modal-pesanbatal<?php echo $json[$i]['idd']; ?>">
                                        <button data-toggle="tooltip" title="Lihat Alasan" class="btn btn-primary btn-xs"><span class="fa fa-envelope"></span></button>
                                    </a>
                            <?php }
                            } ?>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-pesanbatal<?php echo $json[$i]['idd']; ?>">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Alasan Pembatalan</h4>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <p align="justify">
                                            <?php echo $json[$i]['deskripsi_batal']; ?>
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

                    <div class="modal fade" id="modal-cetak-po<?php echo $json[$i]['idd']; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Cetak PO</h4>
                                </div>
                                <div class="modal-body">
                                    <a href="cetak_surat_po_pemesanan2.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Format 1</a>
                                    <a href="cetak_surat_po_pemesanan_dalam_negeri.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Format 2</a>
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
            </tbody>
        </table>
    </div>

</body>

</html>