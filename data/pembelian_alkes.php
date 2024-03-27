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
    $jml = count($json);
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
                    <th valign="top"><strong>Principle</strong></th>
                    <th valign="top">Barang</th>
                    <th align="center" valign="top"><strong>PPN</strong></th>
                    <th align="center" valign="top"><strong>Cara Pembayaran (COD/Tempo)</strong></th>
                    <th align="center" valign="top">Pengiriman</th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php

                for ($i = 0; $i < $jml; $i++) {

                    if ($json[$i]['status_po_batal'] == 1) {
                        $bg = "bg-red";
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
                        <td>
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-principle<?php echo $json[$i]['idd']; ?>"> -->
                            <a href="javascript:void()" onclick="modalPrinciple('<?php echo $json[$i]['principle_id']; ?>')">
                                <button class="btn btn-primary btn-xs">
                                    <span class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        </td>
                        <td>
                            <?php /*if (isset($_GET['tampil']) &&  $_GET['tampil'] == 1) { ?>
                                <?php
                                $q23 = mysqli_query($koneksi, "select nama_brg,tipe_brg,qty,status_ke_stok from barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan_detail.barang_pesan_id=" . $json[$i]['idd'] . "");
                                $n2 = 0;
                                while ($d1 = mysqli_fetch_array($q23)) {
                                    $n2++;
                                ?>
                                    <?php if ($d1['status_ke_stok'] == 1) { ?>
                                        <font class="float-right" size="+1"><span class="fa fa-share"></span></font>
                                    <?php } ?>
                                    <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty']; ?>
                                    <hr style="margin:0px; border-top:1px double; width:100%" />
                                <?php } ?>
                            <?php } else { */?>
                                <!-- <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"> -->
                                <a href="javascript:void();" onclick="modalBarang('<?php echo $json[$i]['idd']; ?>')">
                                    <button class="btn btn-primary btn-xs">
                                        <span class="fa fa-folder-open"></span>
                                    </button>
                                </a>
                            <?php //} ?>
                        </td>
                        <td><?php echo $json[$i]['ppn'] . "%"; ?></td>
                        <td><?php echo $json[$i]['cara_pembayaran']; ?></td>
                        <td>
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-pengiriman<?php echo $json[$i]['idd']; ?>"> -->
                            <a href="javascript:void()" onclick="modalPengiriman('<?php echo $json[$i]['idd']; ?>')">
                                <button class="btn btn-primary btn-xs">
                                    <span class="fa fa-folder-open"></span>
                                </button>
                            </a>
                        </td>
                        <td align="center">
                            <?php if ($json[$i]['status_po_batal'] == 0) { ?>
                                <?php if (isset($_SESSION['pass_administrator'])) { ?>
                                    <a onclick="hapus(<?php echo $json[$i]['idd'] ?>)">
                                        <button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-xs">
                                            <i class="ion-android-delete"></i>
                                        </button>
                                    </a><?php } ?>
                                <?php
                                $cek_uang = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_pesan,utang_piutang,utang_piutang_bayar where barang_pesan.no_po_pesan=utang_piutang.no_faktur_no_po and utang_piutang.id=utang_piutang_bayar.utang_piutang_id and no_po_pesan='" . $json[$i]['no_po_pesan'] . "'"));
                                if ($cek_uang['jml'] == 0 and isset($_SESSION['adminpodalam']) or isset($_SESSION['user_administrator'])) {
                                ?>
                                    <a href="index.php?page=ubah_pembelian_alkes&id=<?php echo $json[$i]['idd']; ?>">
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