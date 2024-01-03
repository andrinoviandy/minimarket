<?php include("../config/koneksi.php"); ?>
<table width="100%" id="" class="table table-bordered table-hover">
  <thead>
    <tr>
      <td align="center"><strong>No</strong></td>
      <td><strong>Username<span class="active"></span></strong></td>
      <td><strong>Tgl Jam Masuk</strong></td>
      <td><strong>Tgl Jam Keluar</strong></td>
      <td><strong>Aktifitas</strong></td>
    </tr>
  </thead>
  <?php
  $start = mysqli_real_escape_string($koneksi, $_GET['start']);
  
  if (isset($_GET['cari'])) {
    $search = $_GET['cari'];
    $jml = mysqli_num_rows(mysqli_query($koneksi, "select * from riwayat_admin where username LIKE '%$search%' order by tgl_jam_masuk DESC, id DESC"));
    $query = mysqli_query($koneksi, "select * from riwayat_admin where username LIKE '%$search%' order by tgl_jam_masuk DESC, id DESC limit $start");
  } else {
    $jml = mysqli_num_rows(mysqli_query($koneksi, "select * from riwayat_admin order by tgl_jam_masuk DESC, id DESC"));
    $query = mysqli_query($koneksi, "select * from riwayat_admin order by tgl_jam_masuk DESC, id DESC limit $start");
  }
  $no = 0;
  while ($data = mysqli_fetch_assoc($query)) {
    $no++;
  ?>
    <tr>
      <td align="center"><?php echo $no; ?></td>
      <td><?php echo $data['username']; ?></td>
      <td><?php echo date("d-m-Y", strtotime($data['tgl_jam_masuk'])) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("H:i:s", strtotime($data['tgl_jam_masuk'])); ?></td>
      <td><?php
          if ($data['tgl_jam_keluar'] != '0000-00-00 00:00:00') {
            echo date("d-m-Y H:i:s", strtotime($data['tgl_jam_keluar']));
          } else {
            echo "Belum Logout";
          } ?>
      </td>
      <td>
      <a onclick="alert('Sedang dalam pengerjaan')"><small data-toggle="tooltip" title="Aktifitas" class="label bg-primary"><span class="fa fa-folder-open"></span>
        </small>
      </a>
      </td>
    </tr>
  <?php } ?>
  <?php
  if ($start <= $jml) {
  ?>
    <tr>
      <td colspan="5">
        <center>
          <img src="loaderr.gif" width="5%" id="loader" style="z-index : -1 ;" />
        </center>
      </td>
    </tr>
  <?php } ?>
  <thead>
    <tr>
      <td colspan="5" align="right">
        <?php
        echo "<b>Data Found : " . $jml . "</b>";
        ?>
      </td>
    </tr>
  </thead>
</table>