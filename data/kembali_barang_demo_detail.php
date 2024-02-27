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
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&id_gudang=$_GET[id_gudang]");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id_gudang=$_GET[id_gudang]");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&id_gudang=$_GET[id_gudang]");
            $file2 = file_get_contents($API . "json/$_GET[page].php?id_gudang=$_GET[id_gudang]");
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
                    <th valign="bottom">Tgl Kirim</th>
                    <th valign="bottom"><strong>Tgl Sampai </strong></th>
                    <th valign="bottom">No Seri</th>
                    <th valign="bottom">Kondisi</th>
                    <th valign="bottom">Keterangan</th>

                    <th valign="bottom">Aksi</th>
                </tr>
            </thead>
            <?php
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_kirim'])); ?></td>
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_sampai'])); ?></td>
                    <td><?php echo $json[$i]['no_seri_brg']; ?></td>
                    <td><?php echo $json[$i]['kondisi']; ?></td>
                    <td><?php echo $json[$i]['keterangan']; ?></td>
                    <td>
                        <!-- <a onclick="return confirm('Anda Yakin Akan Menghapus dan Mengembalikan Status Barang Menjadi Barang Untuk Demo ?')" href="index.php?page=kembali_barang_demo_detail&id_hapus=<?php echo $json[$i]['idd']; ?>&id_gudang=<?php echo $_GET['id_gudang']; ?>&id_detail=<?php echo $json[$i]['barang_gudang_detail_id']; ?>"> -->
                        <a onclick="hapus(<?php echo $json[$i]['idd']; ?>, <?php echo $_GET['id_gudang']; ?>, <?php echo $json[$i]['barang_gudang_detail_id']; ?>)" href="#">
                            <button class="btn btn-xs btn-danger">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>