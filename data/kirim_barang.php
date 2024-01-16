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
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tahun=$_GET[tahun]");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tahun=$_GET[tahun]");
        } else {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
            $file2 = file_get_contents($API . "json/$_GET[page].php?cari=" . $search . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
        }
    } else {
        if (!isset($_GET['tgl1']) && !isset($_GET['tgl2'])) {
            $file = file_get_contents($API . "json/$_GET[page].php?start=$start&tahun=$_GET[tahun]");
            $file2 = file_get_contents($API . "json/$_GET[page].php?tahun=$_GET[tahun]");
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
                    <th align="center">No</th>
                    <th bgcolor="#99FFCC">Tanggal Kirim</th>
                    <th width="20%">Nama Paket</th>
                    <th>No_Surat_Jalan</th>
                    <th>No_PO</th>
                    <th>Barang</th>
                    <th><strong>Lokasi Tujuan</strong></th>
                    <th>Kontak</th>
                    <th>Pengiriman</th>
                    <th bgcolor="#99FFCC"><strong>Tanggal Sampai</strong></th>
                    <th align="center"><strong>Aksi</strong></th>
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
                    <td bgcolor="#99FFCC"><?php echo date("d M Y", strtotime($json[$i]['tgl_kirim'])); ?></td>
                    <td><?php echo $json[$i]['nama_paket']; ?></td>

                    <td><span class="label bg-info" style="color:#000; font-size:12px"><?php echo $json[$i]['no_pengiriman'];
                                                                                        ?></span>
                        <?php if ($json[$i]['status_pengganti'] == 1) {
                            echo "<br><marquee><em>(Barang Pengganti)</em></marquee>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $json[$i]['no_po_jual']; ?>
                    </td>
                    <td>
                        <?php if ($_GET['tampil'] == 1) { ?>
                            <?php
                            $q23 = mysqli_query($koneksi, "select nama_brg,no_seri_brg,status_spi,status_kerusakan,status_batal,tipe_brg from barang_gudang,barang_gudang_detail,barang_dikirim_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $json[$i]['idd'] . "");
                            $n2 = 0;
                            while ($d1 = mysqli_fetch_array($q23)) {
                                $n2++;
                            ?>
                                <?php if ($d1['status_batal'] == 1) { ?>
                                    <font class="pull pull-right" size="">Batal</font>
                                <?php } ?>
                                <font class="pull pull-right" size="">
                                    <?php
                                    if ($d1['status_spi'] == 1) {
                                        echo "(<span class='fa fa-sticky-note-o'></span>)";
                                    }
                                    ?>
                                </font>
                                <?php echo $n2 . ".[" . $d1['nama_brg'] . "]-[" . $d1['tipe_brg'] . "]-[" . $d1['no_seri_brg'] . "]"; ?>
                                <hr style="margin:0px; border-top:1px double; width:100%" />
                            <?php } ?>
                        <?php } else { ?>
                            <!-- <a href="#" data-toggle="modal" data-target="#modal-detailbarang<?php echo $json[$i]['idd']; ?>"> -->
                            <a href="javascript:void()" onclick="modalBarang('<?php echo $json[$i]['idd']; ?>')">
                            <small data-toggle="tooltip" title="Detail Barang" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a>
                        <?php } ?>
                    </td>
                    <td><?php
                        $data3 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_pembeli,kontak_rs from pembeli,barang_dijual,barang_dikirim where pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=" . $json[$i]['idd'] . ""));
                        echo $data3['nama_pembeli']; ?><br />
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-tujuan<?php echo $json[$i]['idd']; ?>"> -->
                        <a href="javascript:void()" onclick="modalTujuan(<?php echo $json[$i]['idd'] ?>, alamat = '<?php echo $json[$i]['alamat2'] ?>')">
                            <small data-toggle="tooltip" title="Input Alamat Ke-2" class="label bg-primary">
                                <span class="fa fa-maps"> Alamat Ke-2</span>
                            </small>
                        </a>
                    </td>
                    <td><?php echo $data3['kontak_rs']; ?></td>
                    <td>
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-kirim<?php //echo $json[$i]['idd']; ?>"> -->
                        <a href="javascript:void()" onclick="modal_kirim('<?php echo $json[$i]['idd']; ?>');">
                        <small data-toggle="tooltip" title="Detail Pengiriman" class="label bg-primary"><span class="fa fa-folder-open"></span></small></a></td>
                    <?php
                    if ($json[$i]['tgl_sampai'] != 0000 - 00 - 00) {
                        $bg = "#99FFCC";
                    } else {
                        $bg = "red";
                    }
                    ?>
                    <td bgcolor=<?php echo $bg; ?>>
                        <?php
                        if ($json[$i]['tgl_sampai'] != 0000 - 00 - 00) {
                            echo date("d M Y", strtotime($json[$i]['tgl_sampai']));
                        } else {
                            echo "-";
                        } ?>
                    </td>
                    <td align="center">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" style="z-index:000">Aksi
                                <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu">
                                <?php if (!isset($_SESSION['user_cs'])) { ?>
                                    <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_gudang'])) { ?>
                                        <li>
                                            <!-- <a href="index.php?page=kirim_barang&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                                            <a href="javascript:void()" onclick="hapus('<?php echo $json[$i]['idd']; ?>', '<?php echo $json[$i]['barang_dijual_id']; ?>')">
                                                <span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span> Hapus
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=riwayat_panggilan&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Riwayat Panggilan CS" class="fa fa-phone-square"></span> Riw. Pangg. CS</a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="index.php?page=ubah_barang_kirim&id=<?php echo $json[$i]['idd']; ?>">
                                            <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span> Ubah
                                        </a>
                                    </li>
                                    <!--<a target="blank" href="cetak_surat_perintah_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Surat Perintah Instalasi" class="glyphicon glyphicon-print"></span></a><a href="cetak_surat_perintah_instalasi.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Buat Surat Perintah Instalasi" class="fa fa-file-pdf-o"></span></a>-->
                                    <li>
                                        <!-- <a href="#" data-toggle="modal" data-target="#modal-status<?php echo $json[$i]['idd']; ?>"> -->
                                        <a href="javascript:void()" onclick="sudahSampai(<?php echo $json[$i]['idd']; ?>, '<?php echo $json[$i]['tgl_sampai']; ?>')">
                                            <span data-toggle="tooltip" title="Status : Sudah Sampai" class="fa fa-calendar-check-o"></span> Status : Sudah Sampai</a>
                                    </li>
                                    <li>
                                        <!-- <a href="index.php?page=kirim_barang&id_b_s=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Yakin Akan Membatalkan Tanggal Sampai Barang !')"> -->
                                        <a href="javascript:void()" onclick="batalSampai(<?php echo $json[$i]['idd']; ?>)">
                                            <span data-toggle="tooltip" title="Status : Belum Sampai" class="fa fa-calendar-times-o"></span> Status : Belum Sampai</a>
                                    </li>
                                    <li><a href="index.php?page=kartu_garansi&id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Kartu Garansi" class="fa fa-print"></span> Cet. Kartu Garansi</a></li>
                                    <li>
                                        <!-- <a href="#" data-toggle="modal" data-target="#modal-cetak-surat-jalan<?php //echo $json[$i]['idd']; ?>"> -->
                                        <a href="javascript:void()" onclick="modal_cetak_surat_jalan('<?php echo $json[$i]['idd']; ?>')">
                                        <span data-toggle="tooltip" title="Cetak Surat Jalan" class="fa fa-print"></span> Cet. Surat Jalan</a>
                                    </li>
                                    <?php if (isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_manajer_keuangan']) or isset($_SESSION['user_administrator'])) { ?><li><a target="blank" href="cetak_faktur_penjualan.php?id=<?php echo $json[$i]['idd']; ?>"><span data-toggle="tooltip" title="Cetak Faktur Penjualan" class="glyphicon glyphicon-print"></span> Cet. Faktur Penjualan</a></li><?php } ?>
                                <?php } else { ?>
                                    <li>
                                        <a href="index.php?page=riwayat_panggilan&id=<?php echo $json[$i]['idd']; ?>">
                                            <span class="fa fa-phone-square"></span> Riwayat Panggilan</a>
                                    </li>
                                <?php } ?>


                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>