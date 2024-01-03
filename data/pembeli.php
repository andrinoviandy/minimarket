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
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "");
        $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "");
    } else {
        $file = file_get_contents($API . "json/$_GET[page].php?start=$start");
        $file2 = file_get_contents($API . "json/$_GET[page].php");
    }
    $json = json_decode($file, true);
    $jml = count($json);

    $json2 = json_decode($file2, true);
    $jml2 = $file2;

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th align="center">&nbsp;</th>


                    <th valign="top"><strong>Nama Pembeli</strong></th>
                    <th valign="top"><strong>Provinsi</strong></th>
                    <th valign="top"><strong>Kabupaten</strong></th>
                    <th valign="top">Kecamatan</th>
                    <th align="center" valign="top"><strong>Kelurahan</strong></th>
                    <th align="center" valign="top"><strong>Jalan</strong></th>

                    <th align="center" valign="top"><strong>Kontak</strong></th>


                    <th align="center" valign="top"><strong>Aksi</strong></th>

                </tr>
            </thead>
            <?php
            // membuka file JSON
            // $file = file_get_contents("http://localhost/ALKES/json/pembeli.php");
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>

                    <td>
                        <?php echo $json[$i]['nama_pembeli']; ?>
                    </td>

                    <td><?php echo $json[$i]['nama_provinsi']; ?></td>
                    <td><?php echo $json[$i]['nama_kabupaten']; ?></td>
                    <td><?php echo $json[$i]['nama_kecamatan']; ?></td>
                    <td align=""><?php echo $json[$i]['kelurahan_id']; ?></td>
                    <td align=""><?php echo $json[$i]['jalan']; ?></td>

                    <td align=""><?php echo $json[$i]['kontak_rs']; ?></td>
                    <td align="">
                        <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_admin_keuangan'])) { ?>
                            <a href="index.php?page=ubah_pembeli&nama_pembeli=<?php echo $json[$i]['nama_pembeli']; ?>">
                            <button class="btn btn-xs btn-info">
                                <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                            </button>    
                            </a>
                            <!--<a href="index.php?page=barang_masuk&id=<?php //echo $json[$i]['idd']; ?>#openPilihan"><small data-toggle="tooltip" title="Jual Alkes" class="label bg-blue">Jual</small></a>-->
                        <?php } ?>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>