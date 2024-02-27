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

                    <th valign="top">Tanggal_SPI</th>
                    <th valign="top">No SPI</th>
                    <th valign="top">No PO</th>
                    <th valign="top">Barang</th>

                    <th valign="top" bgcolor="#00FFFF"><strong>RS/Dinas/Puskesmas</strong></th>
                    <th valign="top"><strong>Kontak</strong></th>

                    <th valign="top"><strong>Deskripsi</strong></th>
                    <th align="center" valign="top"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // if (isset($_SESSION['id_b'])) {
            //     if (isset($_GET['pilihan']) and isset($_GET['kunci'])) {
            //         $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&id_teknisi=$_SESSION[id_b]&pilihan=$_GET[pilihan]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            //     } elseif (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
            //         $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id_teknisi=$_SESSION[id_b]");
            //     } else {
            //         $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&id_teknisi=$_SESSION[id_b]");
            //     }
            // } else {
            //     if (isset($_GET['pilihan']) and isset($_GET['kunci'])) {
            //         $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&pilihan=$_GET[pilihan]&kunci=" . str_replace(" ", "%20", $_GET['kunci']) . "");
            //     } elseif (isset($_GET['tgl1']) and isset($_GET['tgl2'])) {
            //         $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            //     } else {
            //         $file = file_get_contents("http://localhost/ALKES/json/$_GET[page].php?paging=$_GET[paging]");
            //     }
            // }
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>

                    <td align="center"><?php
                                        echo $start += 1;
                                        ?></td>
                    <td><?php echo date("d/M/Y", strtotime($json[$i]['tgl_spk'])); ?>
                    </td>
                    <td><?php
                        echo $json[$i]['no_spk']; ?></td>
                    <td><?php
                        $spi = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_jual from barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang, barang_gudang_detail,barang_dikirim where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_teknisi.id=" . $json[$i]['idd'] . ""));
                        echo $spi['no_po_jual'];
                        ?></td>
                    <td align="">
                        <?php if ($_GET['tampil'] == 1) {
                        ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select nama_brg,no_seri_brg,status_batal,status_uji,status_teknisi,tipe_brg,barang_teknisi_detail.id as id_detail_teknisi from barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang, barang_gudang_detail where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_teknisi.id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <?php if ($d1['status_teknisi'] == 1) { ?>
                                    <font class="pull pull-right" size="">(<span class='fa fa-user'></span>)</font>
                                <?php } ?>
                                <font class="pull pull-right" size="">
                                    <?php
                                    if ($d1['status_uji'] == 1) {
                                        echo "(<span class='fa fa-wrench'></span>)";
                                    }
                                    ?>
                                </font>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['no_seri_brg'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <a href="javascript:void()" onclick="modalDetailBarang('<?php echo $json[$i]['idd']; ?>'); return false;"><small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>

                    <td bgcolor="#00FFFF"><?php
                                            $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_teknisi_detail,barang_dikirim_detail,barang_dikirim,barang_dijual,pembeli where barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dijual.id=barang_dikirim.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_teknisi_id=" . $json[$i]['idd'] . ""));
                                            echo $sel['nama_pembeli']; ?>
                    </td>

                    <td><?php echo $sel['kontak_rs']; ?></td>
                    <td><?php echo $json[$i]['keterangan_spk']; ?></td>
                    <td align="center">
                        <?php if (!isset($_SESSION['id_b'])) { ?>
                            <a href="index.php?page=pilih_teknisi&id=<?php echo $json[$i]['idd']; ?>" data-toggle="tooltip" title="Teknisi, Estimasi, Tgl Berangkat">
                                <button class="btn btn-xs btn-danger">Teknisi, Estimasi, Tgl Berangkat</button>
                            </a>
                            <br /><br>
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-ubah<?php echo $json[$i]['idd'] ?>" class="label label-warning"> -->
                            <a href="javascript:void()" onclick="modalDeskripsi('<?php echo $json[$i]['idd'] ?>', '<?php echo $json[$i]['keterangan_spk']; ?>')" data-toggle="tooltip" title="Ubah Deskripsi">
                                <button class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Desk.</button>
                            </a>
                            <br /><br>
                        <?php } ?>

                        <?php
                        //if ($json[$i]['status_uji']==0 and $json[$i]['status_teknisi']==1) {
                        { ?>
                            <a data-toggle="tooltip" title="Instalasi & Uji Fungsi" href="index.php?page=simpan_tambah_uji&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-info btn-xs">Instalasi & Uji Fungsi</button>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>