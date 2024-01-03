<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start()
?>
<?php
$start = $_GET['start'];

if (isset($_GET['cari'])) {
  $search = str_replace(" ", "%20", $_GET['cari']);
  $file = file_get_contents($API . "json/$_GET[page].php?start=" . $start . "&cari=" . $search . "");
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
<div class="table-responsive no-padding">
  <table width="100%" id="" class="table table-bordered">
    <thead>
      <tr>
        <td align="center">&nbsp;</th>
        <th valign="top"><strong>Nama Alkes</strong></th>
        <th valign="top">NIE</th>
        <th valign="top"><strong>Merk</strong></th>
        <th valign="top"><strong>Tipe</strong></th>

        <th valign="top"><strong>Negara Asal</strong></th>
        <th align="center" valign="top"><strong>Stok Gudang

          </strong></th>
        <th>Stok PO</th>
        <th>Stok Sisa</th>
        <th align="center" valign="top">Terkirim</th>
        <th align="center" valign="top">Rusak</th>
        <th align="center" valign="top"><strong>Deskripsi Alat
          </strong></th>
        <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
          <th align="center" valign="top"><strong>Harga Beli
            </strong></th>
          <th align="center" valign="top"><strong>Harga Jual
            </strong></th>
        <?php } ?>
        <th align="center" valign="top"><strong>Pengecekan Teknisi</strong> </th>
        <th align="center" valign="top"><strong>Aksi</strong></th>
      </tr>
    </thead>
    <?php
    for ($i = 0; $i < $jml; $i++) {
      //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
      //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
    ?>
      <tr>
        <td align="center"><?php echo $start += 1; ?></td>

        <td>
          <?php echo $json[$i]['nama_brg']; ?>
        </td>
        <td><?php echo $json[$i]['nie_brg']; ?></td>

        <td><?php echo $json[$i]['merk_brg']; ?></td>
        <td><?php echo $json[$i]['tipe_brg']; ?></td>

        <td><?php echo $json[$i]['negara_asal']; ?></td>
        <?php if ($json[$i]['stok_total'] == 0) {
          $color = "red";
        } else {
          $color = "";
        } ?>
        <td align="center" style="background-color:<?php echo $color; ?>"><?php echo $json[$i]['stok_total']; ?></td>
        <td align="center"><?php
                            $stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=" . $json[$i]['idd'] . ""));
                            $stok_po2 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual_qty.barang_gudang_id=" . $json[$i]['idd'] . ""));
                            if ($stok_po1['stok_po'] - $stok_po2 != 0) {
                              echo $stok_po1['stok_po'] - $stok_po2;
                            }
                            ?></td>
        <td><?php
            echo $json[$i]['stok_total'] - ($stok_po1['stok_po'] - $stok_po2);
            ?></td>
        <td align="center"><?php
                            $cek_stok1 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kirim=1 and barang_gudang_id=" . $json[$i]['idd'] . ""));
                            if ($cek_stok1 != 0) {
                              echo $cek_stok1;
                            } else {
                              echo "-";
                            } ?></td>
        <td align="center">
          <?php
          $cek_stok2 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where status_kerusakan=1 and barang_gudang_id=" . $json[$i]['idd'] . ""));
          if ($cek_stok2 != 0) {
            echo $cek_stok2;
          } else {
            echo "-";
          } ?>
        </td>
        <td align="center"><?php echo $json[$i]['deskripsi_alat']; ?></td>
        <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator']) or isset($_SESSION['user_admin_keuangan']) && isset($_SESSION['pass_admin_keuangan'])) { ?>
          <td align="center"><?php echo "Rp " . number_format($json[$i]['harga_beli'], 0, ',', '.') . ",-"; ?></td>
          <td align="center"><?php echo "Rp " . number_format($json[$i]['harga_satuan'], 0, ',', '.') . ",-"; ?></td>
        <?php } ?>
        <td align="center">
          <?php if ($json[$i]['status_cek'] == 1) { ?>
            <span class="fa fa-check"></span>
          <?php } else { ?>
            <span class="fa fa-close"></span>
          <?php } ?>
        </td>
        <td align="center">

          <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator'])) { ?>
            <!-- <a href="index.php?page=barang_inventory&id_hapus=<?php echo $json[$i]['idd']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Item Ini ?')"> -->
            <a onclick="hapus(<?php echo $json[$i]['idd']; ?>)">
              <button class="btn btn-danger btn-xs">
                <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
              </button>
            </a>
          <?php } ?>
          <a href="index.php?page=ubah_barang_inventory&id=<?php echo $json[$i]['idd']; ?>">
            <button class="btn btn-info btn-xs">
              <span data-toggle="tooltip" title="Ubah" class="fa fa-folder-open"></span>
            </button>
          </a>

        </td>
      </tr>
    <?php } ?>
  </table>
</div>