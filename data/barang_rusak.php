<?php
error_reporting(0);
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
                    <th align="center">No</th>
                    <th valign="top"><strong>Nama Alkes</strong></th>
                    <th valign="top">NIE</th>
                    <th valign="top"><strong>Merk</strong></th>
                    <th valign="top"><strong>Tipe</strong></th>
                    <th valign="top"><strong>Negara Asal</strong></th>
                    <th align="center" valign="top"><strong>Deskripsi Alat
                        </strong></th>
                    <th align="center" valign="top"><strong>Jumlah</strong> </th>
                    <th align="center" valign="top"><strong>Detail</strong></th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>

                    <td>
                        <?php
                        echo $json[$i]['nama_brg'];
                        ?>
                    </td>
                    <td><?php echo $json[$i]['nie_brg']; ?></td>

                    <td><?php echo $json[$i]['merk_brg']; ?></td>
                    <td><?php echo $json[$i]['tipe_brg']; ?></td>

                    <td><?php echo $json[$i]['negara_asal']; ?></td>
                    <td><?php echo $json[$i]['deskripsi_alat']; ?></td>
                    <td><?php
                        $que = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang,barang_gudang_detail,barang_gudang_detail_rusak where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_gudang_detail_rusak.barang_gudang_detail_id and barang_gudang_id=" . $json[$i]['id_gudang'] . ""));
                        echo $que;
                        ?></td>
                    <td>
                        <a href="index.php?page=barang_rusak_detail&id_gudang=<?php echo $json[$i]['id_gudang']; ?>">
                            <button class="btn btn-xs btn-info">
                                <span data-toggle="tooltip" title="Detail" class="fa fa-caret-square-o-right"></span>
                            </button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>