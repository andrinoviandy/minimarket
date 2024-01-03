<?php
if (isset($_GET['id_hapus'])) {
  $hapus2 = mysqli_query($koneksi, "delete from aksesoris_detail where aksesoris_id=" . $_GET['id_hapus'] . "");
  $hapus1 = mysqli_query($koneksi, "delete from aksesoris_po where aksesoris_id=" . $_GET['id_hapus'] . "");
  $hapus = mysqli_query($koneksi, "delete from aksesoris where id=" . $_GET['id_hapus'] . "");
  if ($hapus and $hapus1 and $hapus2) {
    echo "<script type='text/javascript'>
		window.location='index.php?page=aksesoris'
		</script>";
  } else {
    echo "<script type='text/javascript'>
	alert('Maaf Data Tidak Dapat Dihapus !');	window.location='index.php?page=aksesoris'
		</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Pembeli</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pembeli</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-default">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <a href="index.php?page=tambah_user"><input type="submit" name="button" id="button" value="Tambah Customer" class="btn btn-success" /></a>
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List -->
        <!-- /.box -->

        <!-- quick email widget -->
      </section>
      <?php include "include/header_pencarian.php"; ?>
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <?php include "include/getInputSearch.php"; ?>
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