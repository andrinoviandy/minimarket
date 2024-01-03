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
        <table width="100%" id="" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th valign="top">No</th>

                    <th valign="top">Tanggal Pinjam</th>
                    <th valign="top">Supplier</th>
                    <th valign="top">Kegiatan</th>
                    <th valign="top">Rumah Sakit/Dinas/Dll</th>
                    <th valign="top">Barang</th>
                    <th valign="top">Sisa Kirim</th>

                    <th valign="top"><strong>Estimasi Kembali</strong></th>
                    <th valign="top">Subdis</th>
                    <th valign="top">PIC</th>

                    <!--<th valign="top"><strong>Teknisi</strong></th>-->
                    <th valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>

                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_pinjam'])); ?>
                    </td>
                    <td><?php
                        echo $json[$i]['supplier']; ?></td>
                    <td><?php
                        echo $json[$i]['deskripsi_kegiatan']; ?></td>
                    <td><?php
                        echo $json[$i]['nama_pembeli']; ?></td>
                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select * from barang_gudang,barang_demo,barang_demo_qty where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo.id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>

                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q24 = mysqli_query($koneksi, "select *,barang_demo_qty.id as id_det_jual from barang_demo_qty,barang_demo,barang_gudang where barang_demo.id=barang_demo_qty.barang_demo_id and barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo_qty.barang_demo_id=" . $json[$i]['idd'] . "");
                            $n3 = 0;
                            while ($d1 = mysqli_fetch_array($q24)) {
                                $n3++;
                            ?>
                                <?php
                                $q4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail where barang_demo_qty_id=" . $d1['id_det_jual'] . ""));

                                if ($d1['qty'] - $q4 == 0) {
                                    echo "<span class='fa fa-check pull pull-right'></span>";
                                } else {
                                    echo "<span class='fa fa-close pull pull-right'></span>";
                                }
                                echo $n3 . "[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['qty'] - $q4 . "]"; ?>

                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-sisakirim<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>

                    <td>
                        <!--<a href="index.php?page=spk_masuk&id_spk=<?php //echo $data['idd']; 
                                                                        ?>#open_detail"><span data-toggle="tooltip" title="Detail Rumah Sakit/Dinas/Puskemas/Klinik" class="fa fa-eye pull pull-left"></span></a>-->
                        <?php
                        if ($json[$i]['estimasi_kembali'] != '0000-00-00') {
                            echo date("d-m-Y", strtotime($json[$i]['estimasi_kembali']));
                        } ?>
                    </td>
                    <td><?php
                        echo $json[$i]['subdis']; ?></td>
                    <td><?php
                        echo $json[$i]['pic']; ?></td>

                    <!--<td><?php
                            $data_tek = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_teknisi where id=" . $json[$i]['teknisi_id'] . ""));
                            echo $data_tek['nama_teknisi']; ?>
                      <a href="index.php?page=spi&id_tek=<?php echo $json[$i]['teknisi_id']; ?>#open_teknisi"><span data-toggle="tooltip" title="Detail Teknisi" class="fa fa-eye pull pull-left"></span></a>
                      </td>-->
                    <td align="center">
                        <?php if ($json[$i]['status'] == 0) { ?>
                            <!-- <a href="index.php?page=barang_demo&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                            <a href="#" onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                            <button class="btn btn-xs btn-danger">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>    
                            </a>
                            &nbsp;
                            <a href="index.php?page=ubah_barang_demo&id_ubah=<?php echo $json[$i]['idd']; ?>">
                            <button class="btn btn-xs btn-warning">
                                <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                            </button>    
                            </a>
                            <br />
                            <?php
                            $q_cek = mysqli_query($koneksi, "select *,barang_demo_qty.id as id_det_jual from barang_demo_qty,barang_demo,barang_gudang where barang_demo.id=barang_demo_qty.barang_demo_id and barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo_qty.barang_demo_id=" . $json[$i]['idd'] . "");
                            $n_cek = 0;
                            while ($d1 = mysqli_fetch_array($q_cek)) {
                                $q4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail where barang_demo_qty_id=" . $d1['id_det_jual'] . ""));
                                $n_cek = $n_cek + $d1['qty'] - $q4;
                            }
                            if ($n_cek != 0) {
                            ?>
                                <a href="#" data-toggle="modal" data-target="#modal-kirim<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Kirim" class="label bg-green">Kirim</small></a>
                            <?php  } ?>
                        <?php } else {
                            echo "Sudah Masuk Stok";
                        } ?>
                    </td>
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
                                        $q2 = mysqli_query($koneksi, "select * from barang_gudang,barang_demo,barang_demo_qty where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo.id=barang_demo_qty.barang_demo_id and barang_demo.id=" . $json[$i]['idd'] . "");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q2)) {
                                            $n++;
                                        ?>
                                            <?php echo "<b>Nama Barang : </b>" . $d1['nama_brg'] . "<br>"; ?>
                                            <?php echo "<b>Tipe Barang : </b>" . $d1['tipe_brg'] . "<br>" ?>
                                            <?php echo "<b>Kuantitas : </b>" . $d1['qty'] . "<br>"; ?>

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

                <div class="modal fade" id="modal-sisakirim<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Sisa Barang Belum Di Kirim</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <p align="justify">

                                        <?php
                                        $q2 = mysqli_query($koneksi, "select *,barang_demo_qty.id as id_det_jual from barang_demo_qty,barang_demo,barang_gudang where barang_demo.id=barang_demo_qty.barang_demo_id and barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo_qty.barang_demo_id=" . $json[$i]['idd'] . "");
                                        $n = 0;
                                        while ($d1 = mysqli_fetch_array($q2)) {
                                            $n++;
                                        ?>
                                            <?php
                                            $q4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail where barang_demo_qty_id=" . $d1['id_det_jual'] . ""));

                                            if ($d1['qty'] - $q4 == 0) {
                                                echo "<h2><span class='fa fa-check pull pull-right'></span></h2>";
                                            } else {
                                                echo "<h2><span class='fa fa-close pull pull-right'></span></h2>";
                                            }
                                            echo "<b>Nama Barang : </b>" . $d1['nama_brg'] . "<br>"; ?>
                                            <?php echo "<b>Tipe Barang : </b>" . $d1['tipe_brg'] . "<br>" ?>
                                            <?php echo "<b>Kuantitas : </b>" . $d1['qty'] . "<br>"; ?>
                                            <?php echo "<b>Barang Belum Di Kirim : </b>";
                                            echo $d1['qty'] - $q4;


                                            ?>

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

                <div class="modal fade" id="modal-kirim<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" align="center">Kirim Barang Demo</h4>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <p align="justify">
                                        <input type="hidden" name="id_kirim" value="<?php echo $json[$i]['idd']; ?>" />
                                        <label>Nama Paket</label>
                                        <input id="input" type="text" placeholder="" name="nama_paket" required>
                                        <label>No. Surat Jalan</label>
                                        <input id="input" type="text" placeholder="" name="no_peng" required>
                                        <label>Ekspedisi</label>
                                        <input id="input" type="text" placeholder="" name="ekspedisi" required>
                                        <label>Tanggal Pengiriman</label>
                                        <input id="input" type="date" placeholder="" name="tgl_kirim" required>
                                        <label>Via Pengiriman</label>
                                        <input id="input" type="text" placeholder="" name="via_kirim" required>
                                        <label>Estimasi Barang Sampai</label>
                                        <input id="input" type="date" placeholder="" name="estimasi_brg_sampai">
                                        <label>Biaya Jasa</label>
                                        <input id="input" type="text" placeholder="" name="biaya_kirim" required="required">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan" id="input" rows="4"></textarea>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button name="kirim_barang" type="submit" class="btn btn-success">Next</button>
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