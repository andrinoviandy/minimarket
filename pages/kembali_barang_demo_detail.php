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
            <div class="box-body no-padding">
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
                <div class="row">
                  <div class="col-lg-12">
                    <div class="col-lg-11">
                      <?php include "include/getInputSearch.php"; ?>
                    </div>
                    <div class="col-lg-1">
                      <?php include "include/atur_halaman.php"; ?>
                    </div>
                  </div>
                </div>

                <div id="table" style="margin-top: 10px;"></div>
                <section class="col-lg-12">
                  <center>
                    <ul class="pagination">
                      <button class="btn btn-default" id="paging-1"><a><i class="fa fa-angle-double-left"></i></a></button>
                      <button class="btn btn-default" id="paging-2"><a><i class="fa fa-angle-double-right"></i></a></button>
                    </ul>
                    <?php include "include/getInfoPagingData.php"; ?>
                  </center>
                </section>
                <br>
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