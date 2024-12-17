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
    <table width="100%" id="" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th align="center">No</th>
          <th valign="top"><strong>Username</strong></th>
          <th valign="top"><strong>Tanggal Masuk</strong></th>
          <th valign="top"><strong>Tanggal Keluar</strong></th>
          <th valign="top">Aktifitas</th>
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
            <?php echo $json[$i]['username']; ?>
          </td>
          <td>
            <?php
            if ($json[$i]['tgl_jam_masuk'] != '0000-00-00 00:00:00') {
              echo date("d-m-Y H:i:s", strtotime($json[$i]['tgl_jam_masuk']));
            } else {
              echo "-";
            }
            ?>
          </td>
          <td>
            <?php
            if ($json[$i]['tgl_jam_keluar'] != '0000-00-00 00:00:00') {
              echo date("d-m-Y H:i:s", strtotime($json[$i]['tgl_jam_keluar']));
            } else {
              echo "-";
            }
            ?>
          </td>
          <td align="">
            <?php if (isset($_SESSION['user_administrator'])) { ?>
              <!-- <a href="index.php?page=ubah_pembeli&nama_pembeli=<?php echo $json[$i]['nama_pembeli']; ?>"> -->
                <button class="btn btn-xs btn-primary" onclick="modalLihat('<?php echo $json[$i]['idd']; ?>')">
                  <span data-toggle="tooltip" title="Lihat" class="fa fa-eye"></span>
                </button>
              <!-- </a> -->
              <!--<a href="index.php?page=barang_masuk&id=<?php //echo $json[$i]['idd']; 
                                                          ?>#openPilihan"><small data-toggle="tooltip" title="Jual Alkes" class="label bg-blue">Jual</small></a>-->
            <?php } ?>
          </td>

        </tr>
      <?php } ?>
    </table>
  </div>

</body>

</html>