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
        <table width="129%" id="<?php if (isset($_GET['pilihan']) or isset($_GET['tgl_awal'])) {
                                    echo "example1";
                                } else {
                                    echo "example3";
                                } ?>" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th valign="top">No</th>

                    <th valign="top">Tanggal Peminjaman</th>
                    <th valign="top">Pemilik</th>
                    <th valign="top">Di Tujukan Ke</th>
                    <th valign="top">No. Surat Jalan</th>
                    <th valign="top">Kegiatan</th>
                    <th valign="top">Barang</th>
                    <th valign="top"><strong>Estimasi Pengembalian</strong></th>
                    <th valign="top">Tanggal Pengiriman</th>
                    <th valign="top">Tanggal Kembali Ke Gudang</th>
                    <th valign="top">Tanggal Kembali Ke Pemilik</th>
                    <th valign="top">Aksi</th>

                    <!--<th valign="top"><strong>Teknisi</strong></th>-->

                </tr>
            </thead>
            <?php
            // if (isset($_GET['pilihan']) and isset($_GET['kunci'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/peminjaman_barang.php?pilihan=$_GET[pilihan]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            // } elseif (isset($_GET['tgl_awal']) and isset($_GET['tgl_akhir'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/peminjaman_barang.php?tgl_awal=" . $_GET['tgl_awal'] . "&tgl_akhir=" . $_GET['tgl_akhir'] . "");
            // } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/peminjaman_barang.php");
            // }
            // // membuka file JSON
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>

                    <td align="center"><?php echo $i + 1; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_peminjaman'])); ?>
                    </td>
                    <td><?php
                        echo $json[$i]['nama_pembeli']; ?></td>
                    <td>
                        <?php
                        $kir = mysqli_fetch_array(mysqli_query($koneksi, "select tgl_kirim,nama_pembeli from barang_pinjam_kirim,barang_pinjam_kirim_detail,barang_pinjam_detail,pembeli where barang_pinjam_kirim.id=barang_pinjam_kirim_detail.barang_pinjam_kirim_id and barang_pinjam_kirim_detail.barang_gudang_detail_id=barang_pinjam_detail.barang_gudang_detail_id and pembeli.id=barang_pinjam_kirim.pembeli_id and barang_pinjam_id=" . $json[$i]['idd'] . ""));
                        echo $kir['nama_pembeli'];
                        ?>
                    </td>
                    <td><?php
                        echo $json[$i]['no_pengiriman']; ?></td>
                    <td><?php
                        echo $json[$i]['kegiatan']; ?></td>
                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select *,barang_pinjam_detail.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['no_seri_brg'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php
                        if ($json[$i]['estimasi_pengembalian'] != '0000-00-00') {
                            echo date("d/m/Y", strtotime($json[$i]['estimasi_pengembalian']));
                        } ?></td>
                    <td>
                        <?php

                        echo date("d/m/Y", strtotime($kir['tgl_kirim']));
                        ?>
                    </td>
                    <td>
                        <?php
                        $kem = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pinjam_kembali where barang_pinjam_id=" . $json[$i]['idd'] . ""));
                        if ($kem['tgl_kembali_ke_gudang'] != 0000 - 00 - 00) {
                            echo date("d/m/Y", strtotime($kem['tgl_kembali_ke_gudang']));
                        }
                        ?>
                    </td>
                    <td><?php
                        if ($kem['tgl_kembali_ke_pemilik'] != 0000 - 00 - 00) {
                            echo date("d/m/Y", strtotime($kem['tgl_kembali_ke_pemilik']));
                        }
                        ?></td>
                    <td>
                        <?php if ($kir['tgl_kirim'] != 0000 - 00 - 00) { ?>
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-pengembalian<?php echo $json[$i]['idd'] ?>"> -->
                            <a href="#" onclick="modalPengembalian(<?php echo $json[$i]['idd'] ?>)">
                                <button class="btn btn-xs btn-info">
                                    <span data-toggle="tooltip" title="Ubah Tanggal Pengembalian" class="fa fa-calendar"></span>
                                </button>
                            </a>
                        <?php } ?>
                    </td>

                    <!--<td><?php
                            $data_tek = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_teknisi where id=" . $json[$i]['teknisi_id'] . ""));
                            echo $data_tek['nama_teknisi']; ?>
                  <a href="index.php?page=spi&id_tek=<?php echo $json[$i]['teknisi_id']; ?>#open_teknisi"><span data-toggle="tooltip" title="Detail Teknisi" class="fa fa-eye pull pull-left"></span></a>
                  </td>-->

                </tr>
                <div class="modal fade" id="modal-detailbarang<?php echo $json[$i]['idd']; ?>">
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
                                        $q2 = mysqli_query($koneksi, "select *,barang_pinjam_detail.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_id=" . $json[$i]['idd'] . " group by barang_pinjam_detail.id order by nama_brg ASC");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q2)) {
                                            $n++;
                                        ?>
                                            <?php echo "<b>Nama Barang : </b>" . $d1['nama_brg'] . "<br>"; ?>
                                            <?php echo "<b>Tipe Barang : </b>" . $d1['tipe_brg'] . "<br>" ?>
                                            <?php echo "<b>No Seri : </b>" . $d1['no_seri_brg'] . "<br>"; ?>
                                            <?php if ($d1['tgl_pengembalian'] != 0000 - 00 - 00) {
                                                echo " (Sudah Dikembalikan)";
                                            } ?>
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

                <div class="modal fade" id="modal-detailpengembalian<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Detail Pengembalian</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <p align="justify">

                                        <?php
                                        $q2 = mysqli_query($koneksi, "select *,barang_pinjam_detail.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail,barang_pinjam_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_id=" . $json[$i]['idd'] . " group by barang_pinjam_detail.id order by nama_brg ASC");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q2)) {
                                            $n++;
                                        ?>
                                            <a href="#" data-toggle="modal" data-target="#modal-inputtanggal<?php echo $d1['idd'] ?>" class="pull pull-right">
                                                <h3><span data-toggle="tooltip" title="Ubah Tanggal Pengembalian" class="fa fa-calendar"></span></h3>
                                            </a>
                                            <?php echo "<b>Nama Barang : </b>" . $d1['nama_brg'] . "<br>"; ?>
                                            <?php echo "<b>Tipe Barang : </b>" . $d1['tipe_brg'] . "<br>" ?>
                                            <?php echo "<b>No Seri : </b>" . $d1['no_seri_brg'] . "<br>"; ?>
                                            <?php echo "<font style='font-size:18px'><b>Tanggal Pengembalian : </b>";
                                            if ($d1['tgl_pengembalian'] != 0000 - 00 - 00) {
                                                echo date("d/M/Y", strtotime($d1['tgl_pengembalian']));
                                            }
                                            echo "</font><br>"; ?>
                                            <hr />

                                    <div class="modal fade" id="modal-inputtanggal<?php echo $d1['idd']; ?>">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" align="center">Input Tanggal Pengembalian Barang</h4>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="barang_pinjam_detail_id" value="<?php echo $d1['idd']; ?>" />
                                                        <input type="date" class="form-control" name="tgl_pengembalian" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="simpan_tanggal" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
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

</body>

</html>