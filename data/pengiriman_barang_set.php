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
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tahun=$_GET[tahun]");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tahun=$_GET[tahun]");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&tahun=$_GET[tahun]");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tahun=$_GET[tahun]");
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
        <table width="100%" id="" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="4%" align="center">&nbsp;</th>

                    <th width="12%" bgcolor="#99FFCC">Tanggal Kirim</th>
                    <th width="11%">Nama Paket</th>

                    <th width="16%">No Surat Jalan</th>
                    <th width="8%">No PO</th>
                    <th width="9%"><strong>Barang</strong></th>
                    <th width="11%"><strong>Tempat Tujuan</strong></th>
                    <th width="10%">Kontak</th>
                    <th width="12%" bgcolor="#99FFCC"><strong>Tanggal Sampai</strong></th>
                    <th width="7%" align="center"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $i + 1; ?></td>
                    <td bgcolor="#99FFCC"><?php echo date("d M Y", strtotime($json[$i]['tgl_kirim'])); ?></td>
                    <td><?php echo $json[$i]['nama_paket']; ?></td>

                    <td><?php echo $json[$i]['no_pengiriman']; ?></td>
                    <td><?php echo $json[$i]['po_no']; ?></td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                    </td>
                    <td><?php
                        $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli,kontak_rs from pembeli,barang_dijual_set,barang_dikirim_set where pembeli.id=barang_dijual_set.pembeli_id and barang_dijual_set.id=barang_dikirim_set.barang_dijual_set_id and barang_dikirim_set.id=" . $json[$i]['idd'] . ""));
                        echo $data3['nama_pembeli']; ?></td>
                    <td><?php echo $data3['kontak_rs']; ?></td>

                    <?php
                    if ($json[$i]['tgl_sampai'] != 0000 - 00 - 00) {
                        $bg = "#99FFCC";
                    } else {
                        $bg = "red";
                    }
                    ?>
                    <td bgcolor=<?php echo $bg; ?>>
                        <?php
                        if ($json[$i]['tgl_sampai'] != 0000 - 00 - 00) {
                            echo date("d M Y", strtotime($json[$i]['tgl_sampai']));
                        } else {
                            echo "-";
                        } ?>
                    </td>
                    <td align="center">
                        <?php if (!isset($_SESSION['user_cs'])) { ?>
                            <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_gudang'])) { ?>
                                <a href="index.php?page=pengiriman_barang_set&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a>&nbsp;&nbsp;<a href="index.php?page=riwayat_panggilan_set&id=<?php echo $json[$i]['idd']; ?>">
                                    <span class="fa fa-phone-square"></span>
                                </a>&nbsp;
                            <?php } ?>
                            <a href="index.php?page=ubah_barang_kirim_set&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></a><br />

                            <a href="index.php?page=pengiriman_barang_set&id=<?php echo $json[$i]['idd']; ?>#openSampai">
                                <span data-toggle="tooltip" title="Status : Sudah Sampai" class="fa fa-calendar-check-o"></span>
                            </a>&nbsp;&nbsp;

                            <a href="index.php?page=pengiriman_barang_set&id_b_s=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Yakin Akan Membatalkan Tanggal Sampai Barang !')">
                                <span data-toggle="tooltip" title="Status : Belum Sampai" class="fa fa-calendar-times-o"></span>
                            </a><br />
                            <a href="cetak_surat_jalan_set.php?id=<?php echo $json[$i]['idd']; ?>" target="_blank"><span data-toggle="tooltip" title="Cetak Surat Jalan" class="fa fa-print"></span></a> <?php } else { ?>
                            <a href="index.php?page=riwayat_panggilan&id=<?php echo $json[$i]['idd']; ?>">
                                <span class="fa fa-phone-square"></span>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <div class="modal fade" id="modal-detailbarang<?php echo $json[$i]['idd'] ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Rincian Barang Satuan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-title">
                                    No.SJ : <?php echo $json[$i]['no_pengiriman']; ?><div class="pull pull-right">No.PO : <?php echo $json[$i]['po_no']; ?></div>
                                </div>
                                <div class="box box-body col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 bg-info" style="padding:5px; border:1px solid;"><strong>Nama Barang (Set)</strong></div>
                                        <div align="center" class="col-lg-4 bg-info" style="padding:5px; border:1px solid"><strong>Barang (Satuan)</strong></div>
                                        <div align="center" class="col-lg-4 bg-info" style="padding:5px; border:1px solid"><strong>No. Seri</strong></div>
                                    </div>
                                    <?php
                                    $q_satuan = mysqli_query($koneksi, "select *, barang_gudang_set.nama_brg as nama_set, barang_gudang.nama_brg as nama_brg_satuan from barang_dikirim_set_detail, barang_gudang_set, barang_gudang, barang_gudang_detail, barang_dijual_qty_set where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_set_detail.barang_gudang_detail_id and barang_gudang_set.id=barang_dijual_qty_set.barang_gudang_set_id and barang_dikirim_set_id= " . $json[$i]['idd'] . "");
                                    while ($dt = mysqli_fetch_array($q_satuan)) {
                                    ?>
                                        <div class="row">
                                            <div class="col-lg-4" style="padding:5px; border:1px solid"><?php echo $dt['nama_set'] ?>&nbsp;</div>
                                            <div align="center" class="col-lg-4" style="padding:5px; border:1px solid"><?php echo $dt['nama_brg_satuan'] ?>&nbsp;</div>
                                            <div align="center" class="col-lg-4" style="padding:5px; border:1px solid"><?php echo $dt['no_seri_brg'] ?>&nbsp;</div>
                                        </div>
                                    <?php } ?>
                                </div>
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
        </table>
    </div>

</body>

</html>