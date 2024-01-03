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
    <title></title>

</head>

<body>
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
    <div class="table-responsive">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th align="center"><strong>Tanggal Jual</strong></th>
                    <th align="center">No Faktur</th>
                    <th align="center"><strong>Nama Brg<span class="pull pull-right">Qty Jual (Set)</span></strong></th>
                    <th align="center"><strong>Dinas/RS/Puskemas/Klinik</strong></th>
                    <th align="center">Nama Pemakai</th>

                    <th align="center">Diskon</th>
                    <th align="center">PPN</th>
                    <th align="center">Marketing</th>
                    <th align="center">SubDis</th>
                    <th align="center"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // $file = file_get_contents("http://localhost/ALKES/json/penjualan_barang_set.php");
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php if ($json[$i]['tgl_jual'] != '0000-00-00') {
                            echo date("d F Y", strtotime($json[$i]['tgl_jual']));
                        }
                        ?>
                    </td>
                    <td><?php echo $json[$i]['no_faktur_jual'];
                        ?></td>
                    <td>
                        <table width="100%" class="table">
                            <?php
                            $q2 = mysqli_query($koneksi, "select * from barang_dijual_qty_set,barang_gudang_set where barang_gudang_set.id=barang_dijual_qty_set.barang_gudang_set_id and barang_dijual_set_id=" . $json[$i]['idd'] . "");
                            $n = 0;
                            while ($d1 = mysqli_fetch_array($q2)) {
                                $n++;
                                if ($n % 2 == 0) {
                                    $col = "bg-white";
                                } else {
                                    $col = "bg-gray";
                                }
                            ?>
                                <tr class="<?php echo $col; ?>">
                                    <td align="left"><?php echo $d1['nama_brg']; ?></td>
                                    <td align="left"><?php echo $d1['qty_set']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                    <td><a href="#" data-toggle="modal" data-target="#modal-pembeli<?php echo $json[$i]['idd']; ?>" style="color:#060" title="Klik Untuk Lebih Lengkap"><?php
                                                                                                                                                                        $data_pem = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual_set,pembeli,pemakai where pembeli.id=barang_dijual_set.pembeli_id and pemakai.id=barang_dijual_set.pemakai_id and barang_dijual_set.id=" . $json[$i]['idd'] . ""));
                                                                                                                                                                        echo $data_pem['nama_pembeli']; ?></a></td>
                    <td><?php echo $data_pem['nama_pemakai']; ?></td>

                    <td align="center"><?php echo $json[$i]['diskon_jual'] . " %"; ?></td>
                    <td align="center"><?php echo $json[$i]['ppn_jual'] . " %"; ?></td>
                    <td align="center"><?php echo $json[$i]['marketing']; ?></td>
                    <td align="center"><?php echo $json[$i]['subdis']; ?></td>
                    <td align="center">
                        <?php
                        if (!isset($_SESSION['user_admin_keuangan'])) { ?>
                            <!-- <a href="index.php?page=penjualan_barang_set&id=<?php echo $json[$i]['idd']; ?>#openKirim"> -->
                            <a data-toggle="modal" data-target="#modal-kirim<?php echo $json[$i]['idd']; ?>">
                                <button data-toggle=" tooltip" title="Kirim Alkes" class="label bg-blue">Kirim</button>
                            </a>
                            <a href="index.php?page=detail_jual_barang_set&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Kirim" class="label bg-yellow">Lihat</small></a><br />
                        <?php } ?>
                        <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
                            <!--<a href="pages/delete_barang_jual.php?id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>&nbsp;-->
                            <a href="index.php?page=ubah_barang_jual_set&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-xs btn-info">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                                </button>
                            </a>
                            &nbsp;
                            <a href="index.php?page=penjualan_barang_set&id_batal=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Yakin Akan Membatalkan Penjualan Item Ini ? . Proses ini akan berhasil jika barang belum dikirim !')">
                                <button class="btn btn-xs btn-danger">
                                    <span data-toggle="tooltip" title="Batalkan Penjualan" class="fa fa-close"></span>
                                </button>
                            </a>
                            <br />
                        <?php } ?>
                        <?php if (!isset($_SESSION['user_admin_gudang'])) { ?>
                            <a target="blank" href="cetak_faktur_penjualan_set.php?id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-xs btn-primary">
                                    <span data-toggle="tooltip" title="Cetak Faktur Penjualan" class="glyphicon glyphicon-print"></span>
                                </button>
                            </a>
                        <?php } ?>

                    </td>
                </tr>
                <div class="modal fade" id="modal-pembeli<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Data RS/Dinas/Klinik/Dll</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <p align="justify">
                                        <?php
                                        echo "<b>Nama RS/Dinas/Klinik/Dll :</b> <br/>" . $data_pem['nama_pembeli']; ?>
                                        <hr />
                                        <?php echo "<b>Alamat :</b> <br/>" . str_replace("<br>", "", $data_pem['jalan']); ?>
                                        <hr />
                                        <?php echo "<b>Kontak :</b> <br/>" . $data_pem['kontak_rs']; ?>

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
                <div class="modal fade" id="modal-kirim<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Pengiriman Barang</h4>
                            </div>
                            <form method="post">
                                <input type="hidden" name="id_ubah" value="<?php echo $json[$i]['idd']; ?>" />
                                <div class="modal-body">
                                    <?php
                                    $q5 = mysqli_query($koneksi, "select * from barang_dijual_set where id=" . $_GET['id'] . "");
                                    $d4 = mysqli_num_rows($q4);
                                    ?>
                                    <label>Nama Paket</label>
                                    <input id="input" type="text" placeholder="" name="nama_paket" required>
                                    <label>No. Pengiriman</label>
                                    <input id="input" type="text" placeholder="" name="no_peng" required>
                                    <label>Tanggal Pengiriman</label>
                                    <input id="input" type="date" placeholder="" name="tgl_kirim" required>
                                    <label>No. Faktur</label>
                                    <input id="input" type="text" placeholder="" readonly="readonly" name="no_po" value="<?php echo $json[$i]['no_faktur_jual'] ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button class="btn btn-success" name="kirim_barang" type="submit">Next</button>
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

</body>

</html>