<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start()
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
                    <td align="center">#</td>

                    <td><strong>Instansi</strong></td>

                    <td><strong>Alamat</strong></td>
                    <td><strong>Kontak</strong></td>

                    <?php if (!isset($_SESSION['id_b'])) { ?>
                        <td align="center"><strong>Aksi</strong></td>
                    <?php } ?>
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
                    <tr>
                        <td align="center"><?php echo $start += 1; ?></td>

                        <td><?php echo $json[$i]['nama_pembeli']; ?></td>

                        <td><?php echo $json[$i]['jalan'] . ", " . $json[$i]['kelurahan_id'] . ", " . $json[$i]['nama_kecamatan'] . ", " . $json[$i]['nama_kabupaten'] . ", " . $json[$i]['nama_provinsi']; ?></td>
                        <td><?php echo $json[$i]['kontak_rs']; ?></td>

                        <?php if (!isset($_SESSION['id_b'])) { ?>
                            <td align="center">
                                <a href="index.php?page=laporan_kerusakan_lama_cs&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Detail" class="fa fa-caret-square-o-right"></span></a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>