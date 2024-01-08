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
                    <th>Nama RS/Dinas/Pusk./dll</th>
                    <td align="center"><strong>Alamat</strong> </td>

                    <td align="center"><strong>Kontak RS/Dinas/Dll</strong></td>
                    <td align="center"><strong>Aksi</strong></th>
                </tr>
            </thead>
            <?php
            // if (isset($_SESSION['id_b'])) {
            //     $query = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual,barang_dijual_detail, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_dijual.id=barang_dijual_detail.barang_dijual_id and barang_dijual_detail.id=barang_dikirim_detail.barang_dijual_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and tb_teknisi.id=$_SESSION[id_b] group by pembeli.id");
            // } else {
            //     $query = mysqli_query($koneksi, "select *,alat_uji_detail.id as idd,pembeli_id as id_rumkit from barang_teknisi,barang_teknisi_detail,barang_teknisi_detail_teknisi, barang_dikirim,barang_dikirim_detail, barang_dijual, barang_gudang, barang_gudang_detail,pembeli, tb_teknisi,alat_uji_detail,alat_pelatihan where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_teknisi_detail.id=barang_teknisi_detail_teknisi.barang_teknisi_detail_id and tb_teknisi.id=barang_teknisi_detail_teknisi.teknisi_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id group by pembeli.id");
            // }
            // $no = 0;
            // while ($json[$i] = mysqli_fetch_assoc($query)) {
            //     $no++;
            for ($i = 0; $i < $jml; $i++) {
            ?>
                <tr>
                    <td align="center"><?php echo $start += 1; ?></td>
                    <td><?php echo $json[$i]['nama_pembeli']; ?></td>
                    <td align="center"><?php echo $json[$i]['jalan'] . ", Kelurahan " . $json[$i]['kelurahan_id']; ?></td>
                    <td align="center"><?php echo $json[$i]['kontak_rs']; ?></td>
                    <td align="center">
                        <a href="index.php?page=pelatihan_alat_lama&id_rumkit=<?php echo $json[$i]['id_rumkit']; ?>">
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