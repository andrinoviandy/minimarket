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

    $json2 = json_decode($file2, true);
    $jml2 = count($json2);

    ?>
    <div>
        <em><?php echo "Jumlah Data Yang Ditemukan : " . $jml2 ?></em>
    </div>
    <div class="table-responsive">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th valign="bottom"><strong>Tgl SPI</strong></th>
                    <th valign="bottom">No SPI</th>
                    <th valign="bottom">Nama Alkes</th>
                    <th valign="bottom">No Seri</th>
                    <th valign="bottom">Software Vers.</th>
                    <th valign="bottom">Tgl Garansi Habis</th>
                    <th valign="bottom">Tgl Instalasi</th>
                    <th valign="bottom">Lampiran Instalasi</th>
                    <th valign="bottom">Tgl Uji Fungsi</th>
                    <th valign="bottom">Lampiran U. Fungsi</th>
                    <th valign="bottom"><strong>Teknisi</strong></th>
                    <th valign="bottom">Kontak Teknisi</th>
                    <th valign="bottom">Keterangan</th>
                    <th valign="bottom">Aksi</th>
                </tr>
            </thead>
            <?php

            // membuka file JSON
            // if (isset($_SESSION['id_b'])) {
            //     $file = file_get_contents("http://localhost/ALKES/json/ubah_uji.php?id_rumkit=$_GET[id_rumkit]&id_b=$_SESSION[id_b]");
            // } else {
            //     $file = file_get_contents("http://localhost/ALKES/json/ubah_uji.php?id_rumkit=$_GET[id_rumkit]");
            // }
            // $json = json_decode($file, true);
            // $jml = count($json);
            for ($i = 0; $i < $jml; $i++) {
                //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
            ?>
                <tr>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_spk'])); ?></td>
                    <td><?php echo $json[$i]['no_spk']; ?></td>
                    <td <?php if ($json[$i]['status_batal'] == 1) {
                            echo "bgcolor='red'";
                        } ?>><?php echo $json[$i]['nama_brg']; ?></td>
                    <td><?php echo $json[$i]['no_seri_brg'] . " " . $json[$i]['nama_set']; ?></td>
                    <td><?php echo $json[$i]['soft_version']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_garansi_habis'])); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_i'])); ?></td>
                    <td>
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-ubahinstalasi<?php //echo $json[$i]['idd'] 
                                                                                                ?>"> -->
                        <a href="#" onclick="lampiranInstalasi(<?php echo $json[$i]['idd'] ?>)">
                            <small data-toggle="tooltip" title="Ubah Lampiran" class="label bg-blue pull pull-right pull-top">Ubah</small>
                        </a>
                        <?php if ($json[$i]['lampiran_i'] != '') { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-instalasi<?php echo $json[$i]['idd']; ?>">
                                <img src="gambar_fi/instalasi/<?php echo $json[$i]['lampiran_i']; ?>" width="50px" />
                            </a>
                        <?php } ?>
                    </td>
                    <td><?php echo date("d/m/Y", strtotime($json[$i]['tgl_f'])); ?></td>
                    <td>
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-ubahfungsi<?php echo $json[$i]['idd'] ?>"> -->
                        <a href="#" onclick="lampiranUjiFungsi(<?php echo $json[$i]['idd'] ?>)">
                            <small data-toggle="tooltip" title="Ubah Lampiran" class="label bg-blue pull pull-right pull-top">Ubah</small>
                        </a>
                        <?php if ($json[$i]['lampiran_f'] != '') { ?>
                            <a href="#" data-toggle="modal" data-target="#modal-ujifungsi<?php echo $json[$i]['idd']; ?>"><img src="gambar_fi/fungsi/<?php echo $json[$i]['lampiran_f']; ?>" width="50px" /></a>
                        <?php } ?>
                    </td>
                    <td><?php echo $json[$i]['nama_teknisi']; ?></td>
                    <td><?php echo $json[$i]['no_hp'] . " / " . $_SESSION['kontak2']; ?></td>
                    <td><?php echo $json[$i]['keterangan']; ?></td>
                    <td align="center">
                        <!-- <a href="pages/delete_uji.php?id_hapus=<?php echo $json[$i]['idd']; ?>&id_rumkit=<?php echo $_GET['id_rumkit']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
                        <a href="#" onclick="hapus(<?php echo $json[$i]['idd']; ?>, <?php echo $_GET['id_rumkit']; ?>)">
                            <button class="btn btn-xs btn-danger">
                                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                            </button>
                        </a>
                        &nbsp;
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-ubah<?php echo $json[$i]['idd']; ?>"> -->
                        <a href="#" onclick="modalUbah(<?php echo $json[$i]['idd']; ?>, '<?php echo $json[$i]['soft_version']; ?>', '<?php echo $json[$i]['tgl_garansi_habis']; ?>', '<?php echo $json[$i]['tgl_i']; ?>', '<?php echo $json[$i]['tgl_f']; ?>', '<?php echo $json[$i]['keterangan'] ?>')">
                            <button class="btn btn-xs btn-warning">
                                <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span>
                            </button>
                        </a>
                        &nbsp;
                        <a target="_blank" href="cetak_laporan_instalasi.php?id=<?php echo $json[$i]['idd']; ?>">
                            <button class="btn btn-xs btn-primary">
                                <span data-toggle="tooltip" title="Download Report" class="glyphicon glyphicon-print"></span>
                            </button>
                        </a>
                        <br />
                        <?php
                        //$lihat = mysqli_num_rows(mysqli_query($koneksi, "select * from alat_pelatihan where alat_uji_detail_id=".$json[$i]['idd'].""));
                        if ($json[$i]['status_pelatihan'] == 0) { ?>
                            <a href="index.php?page=tambah_pelatihan&id=<?php echo $json[$i]['idd']; ?>"><small data-toggle="tooltip" title="Pelatihan Alat" class="label bg-blue">Pelatihan</small></a>
                        <?php } ?>
                    </td>
                </tr>

                <div class="modal fade" id="modal-instalasi<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <img src="gambar_fi/instalasi/<?php echo $json[$i]['lampiran_i']; ?>" width="100%" height="auto" />
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

                <div class="modal fade" id="modal-ujifungsi<?php echo $json[$i]['idd']; ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <img src="gambar_fi/fungsi/<?php echo $json[$i]['lampiran_f']; ?>" width="100%" height="auto" />
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

                
            <?php } ?>
        </table>
    </div>

</body>

</html>