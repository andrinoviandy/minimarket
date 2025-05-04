<?php
if (isset($_POST['button_urut'])) {
  echo "<script>window.location='cetak_stok_alkes.php?merk=$_POST[merk]'</script>";
}
?>
<?php
if (isset($_GET['id_hapus'])) {
  $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from deposit where id=" . $_GET['id_hapus'] . ""));
  $up1 = mysqli_query($koneksi, "update buku_kas set saldo=saldo+$sel[nominal_deposit] where id=" . $sel['dari_akun_id'] . "");
  $up2 = mysqli_query($koneksi, "update buku_kas set saldo=saldo-$sel[nominal_deposit] where id=" . $sel['ke_akun_id'] . "");
  if ($up1 and $up2) {
    $del2 = mysqli_query($koneksi, "delete from deposit where id=" . $_GET['id_hapus'] . "");
    if ($del2) {
      echo "<script>
	alert('Data Berhasil Dihapus !');
	window.location='index.php?page=deposit'</script>";
    } else {
      echo "<script>
	alert('Data Gagal Dihapus !');
	window.location='index.php?page=deposit'</script>";
    }
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Deposit</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Buku Kas</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
                <a href="index.php?page=tambah_deposit">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
              </div>
              <div class="pull pull-right">
                <?php include "include/getFilter.php"; ?>
                <?php include "include/atur_halaman.php"; ?>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
      </section>
      <?php include "include/header_pencarian.php"; ?>
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-warning">
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
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>