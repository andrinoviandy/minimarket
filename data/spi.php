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
                    <th valign="top">No Surat Jalan</th>
                    <th valign="top">No PO</th>
                    <th valign="top">Barang</th>

                    <th valign="top"><strong>RS/Dinas/Puskesmas/Dll</strong></th>
                    <th valign="top">Kontak </th>
                    <th valign="top">Deskripsi</th>
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
                    <td><?php echo date("d-m-Y", strtotime($json[$i]['tgl_spk'])); ?>
                    </td>
                    <td><?php
                        echo $json[$i]['no_spk']; ?></td>
                    <td>
                        <span class="label bg-info" style="color:#000; font-size:12px"><?php echo $json[$i]['no_pengiriman'];
                                                                                        ?></span>
                        <?php if ($spi['status_pengganti'] == 1) {
                            echo "<br><marquee><em>(Barang Pengganti)</em></marquee>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $json[$i]['no_po_jual'];
                        ?>
                    </td>
                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select nama_brg,no_seri_brg,status_spi,status_kerusakan,status_batal,tipe_brg from barang_gudang,barang_gudang_detail,barang_dikirim_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $json[$i]['barang_dikirim_id'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                                $d2 = mysqli_fetch_array(mysqli_query($koneksi, "select status_teknisi,status_uji from barang_teknisi_detail where barang_dikirim_detail_id = " . $d1['barang_dikirim_detail.id'] . ""));
                            ?>
                                <?php if ($d2['status_teknisi'] == 1) { ?>
                                    <font class="pull pull-right" size="">(<span class='fa fa-user'></span>)</font>
                                <?php } ?>
                                <font class="pull pull-right" size="">
                                    <?php
                                    if ($d2['status_uji'] == 1) {
                                        echo "(<span class='fa fa-wrench'></span>)";
                                    }
                                    ?>
                                </font>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['no_seri_brg'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"> -->
                            <a href="javascript:void();" onclick="modalBarang('<?php echo $json[$i]['barang_dikirim_id']; ?>')">
                            <small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>

                    <td><?php
                        echo $json[$i]['nama_pembeli']; ?>
                    </td>
                    <td><?php echo $json[$i]['kontak_rs']; ?></td>
                    <td align="center"><?php echo $json[$i]['keterangan_spk']; ?></td>
                    <td align="center">
                        <div class="row">

                            <?php if (!isset($_SESSION['id_b'])) { ?>
                                <!-- <a href="pages/delete_spk_masuk.php?id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                <a href="javascript:void();" onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
                                    <button class="btn btn-xs btn-danger">
                                        <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                                    </button>
                                </a>
                                &nbsp;
                                <!-- <a href="#" data-toggle="modal" data-target="#modal-ubah<?php echo $json[$i]['idd']; ?>"> -->
                                <a href="javascript:void();" onclick="modal_ubah('<?php echo $json[$i]['idd']; ?>')">
                                    <button class="btn btn-xs btn-warning">
                                        <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                                    </button>
                                </a>
                            <?php } ?>
                            <?php
                            if ($ada == 0) { ?>
                                &nbsp;
                                <a href="javascript:void()" onclick="modal_cetak_spi('<?php echo $json[$i]['idd']; ?>','<?php echo $json[$i]['barang_dikirim_id']; ?>')">
                                    <button class="btn btn-xs btn-primary">
                                        <span data-toggle="tooltip" title="Cetak SPI" class="glyphicon glyphicon-print"></span>
                                    </button>
                                </a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>