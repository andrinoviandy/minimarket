<?php
if (isset($_GET['id_hapus'])) {
  $up = mysqli_query($koneksi, "update barang_gudang_detail set status_demo=1 where id=" . $_GET['id_detail'] . "");
  $up2 = mysqli_query($koneksi, "update barang_demo_kirim_detail set status_kembali=0 where barang_gudang_detail_id=" . $_GET['id_detail'] . "");
  $h = mysqli_query($koneksi, "delete from barang_demo_kembali where id=$_GET[id_hapus]");
  if ($up and $up2 and $h) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Dihapus ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location = '?page=$_GET[page]&id_gudang=$_GET[id_gudang]';
    })
    </script>";
  } else {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Data Gagal Dihapus ',
      icon: 'error',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location = '?page=$_GET[page]&id_gudang=$_GET[id_gudang]';
    })
    </script>";
  }
}

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Detail Pengembalian Barang Demo</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Detail Barang Demo</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->

                <table width="100%" id="" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th valign="bottom">Nama Alkes</th>
                      <th valign="bottom">Tipe</th>
                      <th valign="bottom"><strong>Merk</strong></th>
                      <th valign="bottom">Negara Asal</th>
                      <th valign="bottom">Deskripsi alat</th>
                    </tr>
                  </thead>
                  <tr>
                    <td><?php
                        $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id=$_GET[id_gudang]"));
                        echo $sel['nama_brg']; ?></td>
                    <td><?php echo $sel['tipe_brg']; ?></td>
                    <td><?php echo $sel['merk_brg']; ?></td>
                    <td><?php echo $sel['negara_asal']; ?></td>
                    <td><?php echo $sel['deksripsi_alat']; ?></td>
                  </tr>
                </table><br />
                <h3 align="center">
                  Detail Alkes
                </h3>
                <table width="100%" id="example1" class="table table-bordered table-hover">
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

                  // membuka file JSON
                  if (isset($_SESSION['id_b'])) {
                    $file = file_get_contents("http://localhost/ALKES/json/barang_demo_kembali.php?id_gudang=$_GET[id_gudang]&id_b=$_SESSION[id_b]");
                  } else {
                    $file = file_get_contents("http://localhost/ALKES/json/barang_demo_kembali.php?id_gudang=$_GET[id_gudang]");
                  }
                  $json = json_decode($file, true);
                  $jml = count($json);
                  for ($i = 0; $i < $jml; $i++) {
                    //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
                    //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
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
                <p align="left">&nbsp;</p>
                <br />

              </div>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List -->
        <!-- /.box -->

        <!-- quick email widget -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">

        <!-- Map box -->
        <!-- /.box -->

        <!-- solid sales graph -->
        <!-- /.box -->

        <!-- Calendar -->
        <!-- /.box -->

      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>

<script>
  function hapus(id_hapus, id_gudang, id_detail) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Status Barang Akan Menjadi Barang Demo',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id_hapus + '&id_gudang=' + id_gudang + '&id_detail=' + id_detail;
      }
    })
  }
</script>