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
        if (isset($_GET['mutasi'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&tgldari=" . $_GET['tgldari'] . "&tglsampai=" . $_GET['tglsampai'] . "&mutasi=" . $_GET['mutasi'] . "&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&mutasi=" . $_GET['mutasi'] . "&cari=" . $search . "");
        } else if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (isset($_GET['mutasi'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgldari=" . $_GET['tgldari'] . "&tglsampai=" . $_GET['tglsampai'] . "&mutasi=" . $_GET['mutasi'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&mutasi=" . $_GET['mutasi'] . "");
        } else if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
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
        <table width="100%" id="" class="table table-bordered table-hover">
            <thead>

                <tr>
                    <th align="center">#</th>
                    <th valign="top">Tgl PO</th>
                    <th valign="top">No PO</th>
                    <th valign="top">Jenis PO</th>
                    <th valign="top">Nama Principle</th>
                    <th valign="top">Barang</th>
                    <?php if (!isset($_SESSION['user_admin_gudang'])) { ?>

                        <th align="center" valign="top"><strong>PPN</strong></th>
                        <th align="center" valign="top"><strong>Mata Uang</strong></th>
                        <th align="center" valign="top"><strong>Total Price</strong> </th>
                        <th align="center" valign="top">Total Keseluruhan</th>
                    <?php } ?>
                    <th align="center" valign="top">Estimasi Pengiriman</th>
                    <th align="center" valign="top">Tgl Masuk</th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php
                                        echo $start += 1;
                                        ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_po_pesan'])); ?></td>
                    <td><?php echo $json[$i]['no_po_pesan']; ?></td>
                    <td><?php echo $json[$i]['jenis_po']; ?></td>
                    <td><?php echo $json[$i]['nama_principle']; ?></td>

                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select * from barang_pesan,barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_pesan_detail.barang_pesan_id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <?php
                                $stok_sudah_mutasi = mysqli_fetch_array(mysqli_query($koneksi, "select stok as stok_sudah from barang_gudang_po where no_po_gudang='" . $d1['no_po_pesan'] . "' and barang_gudang_id=" . $d1['barang_gudang_id'] . ""));
                                if ($d1['qty'] - $stok_sudah_mutasi['stok_sudah'] <= 0) { ?>
                                    <font class="pull pull-right" size="+1"><span class="fa fa-share"></span></font>
                                <?php } ?>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty']; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>
                    <?php if (!isset($_SESSION['user_admin_gudang'])) { ?>

                        <td><?php echo $json[$i]['ppn'] . "%"; ?></td>
                        <td>
                            <?php
                            $simbol = mysqli_fetch_array(mysqli_query($koneksi, "select jenis_mu,simbol from mata_uang where id=" . $json[$i]['mata_uang_id'] . ""));
                            echo $simbol['jenis_mu'];
                            ?>
                        </td>
                        <td><?php
                            echo $simbol['simbol'] . " " . number_format($json[$i]['total_price'], 0, ',', ',') . ".00";
                            ?></td>
                        <td><?php echo $simbol['simbol'] . " " . number_format($json[$i]['cost_cf'], 0, ',', ',') . ".00"; ?></td>
                    <?php } ?>
                    <td>
                        <?php if ($json[$i]['estimasi_pengiriman'] == 0000 - 00 - 00) {
                            echo "-";
                        } else {
                            echo date("d/m/Y", strtotime($json[$i]['estimasi_pengiriman']));
                        } ?>
                    </td>
                    <td><?php if ($json[$i]['tgl_masuk_gudang'] == 0000 - 00 - 00) {
                            echo "-";
                        } else {
                            echo date("d/m/Y", strtotime($json[$i]['tgl_masuk_gudang']));
                        } ?></td>
                    <td align="center">
                        <?php if ($json[$i]['status_po_batal'] == 0) { ?>
                            <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_manajer_gudang'])) { ?>
                                <!--<a href="index.php?page=barang_gudang1&id=<?php echo $json[$i]['idd']; ?>#openLunas"><small data-toggle="tooltip" title="Tgl Masuk Gudang" class="label bg-green">Tgl Masuk Gudang</small></a>-->
                                <a href="#" data-toggle="modal" data-target="#modal-tglmasuk<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Tgl Masuk Gudang" class="label bg-green">Tgl Masuk Gudang</small></a>
                                <br />
                                <?php if ($json[$i]['status_lunas'] == 1 or $json[$i]['tgl_masuk_gudang'] != '0000-00-00') { ?>
                                    <a href="index.php?page=mutasi&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Mutasi Ke Gudang" class="label bg-yellow">Mutasi</small></a><br />
                                <?php } ?>
                            <?php } ?>
                            <a href="index.php?page=detail_barang_gudang1&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-xs btn-info">
                                    <span data-toggle="tooltip" title="Detail" class="fa fa-caret-square-o-right"></span>
                                </button>
                            </a>

                        <?php } else {
                            echo "DIBATALKAN";
                        } ?>
                    </td>
                </tr>
                <div class="modal fade" id="modal-tglmasuk<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tanggal Masuk Gudang</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="id_tgl" value="<?php echo $json[$i]['idd'] ?>" />
                                    <input id="input<?php echo $json[$i]['idd'] ?>" value="<?php echo $json['tgl_masuk_gudang']; ?>" onchange="ubahTgl(this.value)" type="date" class="form-control" name="tgl_lunas">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button name="lunasin" type="submit" class="btn btn-success" onclick="simpanTgl(<?php echo $json[$i]['idd'] ?>)">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

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
                                        $q = mysqli_query($koneksi, "select * from barang_pesan,barang_pesan_detail,barang_gudang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_pesan_detail.barang_pesan_id=" . $json[$i]['idd'] . "");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q)) {
                                            $n++;

                                        ?>
                                            <?php echo $n . ". " . $d1['nama_brg'] . "     |    "; ?></td>
                                            <?php echo $d1['tipe_brg'] . "  |  " ?></td>
                                            <?php echo $d1['qty'] . "  |  "; ?>
                                            <?php $stok_sudah_mutasi = mysqli_fetch_array(mysqli_query($koneksi, "select stok as stok_sudah from barang_gudang_po where no_po_gudang='" . $d1['no_po_pesan'] . "' and barang_gudang_id=" . $d1['barang_gudang_id'] . ""));
                                            if ($d1['qty'] - $stok_sudah_mutasi['stok_sudah'] == 0) { ?>
                                                <span class="fa fa-share"></span>
                                            <?php } ?>
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

</body>

</html>