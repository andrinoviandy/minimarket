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
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&id_rumkit=$_GET[id_rumkit]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id_rumkit=$_GET[id_rumkit]");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id_rumkit=$_GET[id_rumkit]");
        $file2 = file_get_contents($API . "json/$_GET[page].php?id_rumkit=$_GET[id_rumkit]");
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
                    <td align="center"><strong>No</strong>
                        </th>

                    <th valign="bottom"><strong>Nama Alkes</strong></th>
                    <th valign="bottom"><strong>No Seri</strong></th>

                    <th valign="bottom"><strong>Jumlah Peserta</strong></th>
                    <th valign="bottom"><strong>Pelatih</strong></th>
                    <th valign="bottom"><strong>Tgl Pelatihan</strong></th>
                    <td align="center" valign="bottom"><strong>Pelatihan Oleh</strong>
                    <td align="center" valign="bottom"><strong>Lamp. 1
                        </strong>
                    <td align="center" valign="bottom"><strong>Lamp. 2
                        </strong>
                    <td align="center" valign="bottom"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // if (isset($_SESSION['id_b'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/pelatihan_alat_lama.php?id_rumkit=$_GET[id_rumkit]&id_b=$_SESSION[id_b]");
            // } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/pelatihan_alat_lama.php?id_rumkit=$_GET[id_rumkit]");
            // }
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $i + 1; ?></td>
                    <td <?php if ($json[$i]['status_batal'] == 1) {
                            echo "bgcolor='red'";
                        } ?>><?php echo $json[$i]['nama_brg']; ?>
                    </td>
                    <td><?php echo $json[$i]['no_seri_brg'] . " " . $json[$i]['nama_set']; ?></td>
                    <td><?php echo $json[$i]['banyak_peserta'] . " Orang"; ?></td>
                    <td><?php echo $json[$i]['pelatih']; ?></td>
                    <td><?php echo date("d F Y", strtotime($json[$i]['tgl_pelatihan'])); ?></td>
                    <td align="center"><?php echo $json[$i]['pelatihan_oleh']; ?></td>
                    <td align="center">
                        <a href="javascript:void()" onclick="ubahLamp1('<?php echo $json[$i]['idd'] ?>')">
                        <small data-toggle="tooltip" title="Ubah Lampiran" class="label bg-blue pull pull-right pull-top">Ubah</small></a>
                        <?php if ($json[$i]['lamp1'] != "") { ?>
                            <a href="javascript:void()" onclick="modalLampiran('Lampiran 1','gambar_pelatihan/lampiran1/<?php echo $json[$i]['lamp1']; ?>')"><img src="gambar_pelatihan/lampiran1/<?php echo $json[$i]['lamp1']; ?>" width="50px" /></a>
                        <?php } ?>
                    </td>
                    <td align="center">
                        <a href="javascript:void()" onclick="ubahLamp2('<?php echo $json[$i]['idd'] ?>')">
                        <small data-toggle="tooltip" title="Ubah Lampiran" class="label bg-blue pull pull-right pull-top">Ubah</small></a>
                        <?php if ($json[$i]['lamp2'] != "") { ?>
                            <a href="javascript:void()" onclick="modalLampiran('Lampiran 2', 'gambar_pelatihan/lampiran2/<?php echo $json[$i]['lamp2']; ?>')">
                            <img src="gambar_pelatihan/lampiran2/<?php echo $json[$i]['lamp2']; ?>" width="50px" /></a>
                        <?php } ?>
                    </td>
                    <td align="center" style="width: 7%;">
                        <div class="row">
                            <?php if (!isset($_SESSION['id_b'])) { ?>
                                <!-- <a href="pages/delete_pelatihan.php?id_rumkit=<?php echo $_GET['id_rumkit']; ?>&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                <a href="javascript:void()" onclick="hapus('<?php echo $json[$i]['idd']; ?>')">
                                    <button class="btn btn-xs btn-danger">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                                    </button>
                                </a>
                                &nbsp;
                            <?php } ?>
                            <a href="index.php?page=ubah_latih&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-xs btn-warning">
                                    <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                                </button>
                            </a>
                        </div>
                        <div class="row">
                            <a href="index.php?page=sertifikat&id=<?php echo $json[$i]['idd']; ?>">
                                <button class="btn btn-xs btn-primary">
                                    <span data-toggle="tooltip" title="Cetak Sertifikat Pelatiihan" class="fa fa-print"></span>
                                </button>
                            </a>
                            &nbsp;
                            <a href="cetak_report_training.php?id=<?php echo $json[$i]['idd'] ?>&alkes=<?php echo $json[$i]['nama_brg'] ?>&no_seri=<?php echo $json[$i]['no_seri_brg'] ?>">
                                <button class="btn btn-xs btn-primary">
                                    <span data-toggle="tooltip" title="Download Report" class="glyphicon glyphicon-print"></span>
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>