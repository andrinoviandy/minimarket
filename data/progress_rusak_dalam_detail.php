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
    $id_gudang =  $_GET['id_gudang'];

    if (isset($_GET['cari'])) {
        $search = str_replace(" ", "%20", $_GET['cari']);
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&id_gudang=$id_gudang");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&id_gudang=$id_gudang");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id_gudang=$id_gudang");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id_gudang=$id_gudang");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&id_gudang=$id_gudang");
            $file2 = file_get_contents($API . "json/$_GET[page].php?id_gudang=$id_gudang");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id_gudang=$id_gudang");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "&id_gudang=$id_gudang");
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
                    <th valign="bottom">Tgl Input</th>
                    <th valign="bottom"><strong>Tgl Masuk Gudang</strong></th>
                    <th valign="bottom">No Seri</th>
                    <th valign="bottom">Kerusakan</th>
                    <th valign="bottom">Teknisi</th>
                    <th valign="bottom">Status Progress</th>
                    <th valign="bottom">Status Barang</th>
                    <th valign="bottom">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < $jml; $i++) {
                ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_input'])); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_po_gudang'])); ?></td>
                        <td><?php echo $json[$i]['no_seri_brg']; ?></td>
                        <td><?php echo $json[$i]['kerusakan_alat']; ?></td>
                        <td><?php echo $json[$i]['nama_teknisi']; ?></td>
                        <td><?php if ($json[$i]['status_progress'] == 1) {
                                echo "SELESAI";
                            } else if ($json[$i]['status_progress'] == 0) {
                                echo "BELUM SELESAI";
                            } ?></td>
                        <td><?php if ($json[$i]['status_kerusakan'] == 1) {
                                echo "RUSAK";
                            } else if ($json[$i]['status_kerusakan'] == 2) {
                                echo "Tidak Layak Jual & Kembali Ke Pabrik";
                            } else {
                                echo "Layak Dijual & Kembali Ke Gudang";
                            } ?></td>
                        <td>
                            <a href="index.php?page=tambah_progress_rusak_dalam&id_gudang_detail=<?php echo $json[$i]['id_gudang_detail']; ?>&id_ubah=<?php echo $json[$i]['idd']; ?>&id_gudang=<?php echo $_GET['id_gudang']; ?>"><small data-toggle="tooltip" title="Progress" class="label bg-green"><span class="fa fa-cogs"></span>&nbsp; Progress</small></a>
                            <br />
                            <?php if ($json[$i]['status_progress'] == 1) { ?>
                                <!-- <a href="#" data-toggle="modal" data-target="#modal-status<?php echo $json[$i]['idd'] ?>"><small data-toggle="tooltip" title="Ubah Status Barang" class="label bg-yellow"><span class="fa fa-edit"></span>&nbsp; Ubah Status Barang</small></a> -->
                                <a href="javascript:void()" onclick="ubahStatusBarang('<?php echo $json[$i]['idd'] ?>', '<?php echo $json[$i]['id_gudang_detail']; ?>');"><small data-toggle="tooltip" title="Ubah Status Barang" class="label bg-yellow"><span class="fa fa-edit"></span>&nbsp; Ubah Status Barang</small></a>
                            <?php } ?><!--&nbsp;&nbsp;<a target="_blank" href="cetak_laporan_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Download Report" class="glyphicon glyphicon-print"></span></a><br />-->
                            <?php /*if ($json[$i]['status_dikembalikan']==1) { ?>
                      <a href="index.php?page=tambah_pelatihan&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Kembalikan Ke Stok Gudang" class="label bg-blue"><span class="fa fa-share"></span> Stok</small></a> <?php }*/ ?>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>