<?php
if (isset($_POST['simpan_tambah_aksesoris'])) {
  //$no=mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash"))+1;
  $simpan = mysqli_query($koneksi, "insert into barang_gudang_detail_rusak values('','" . $_POST['tgl_input'] . "','" . $_POST['no_seri'] . "','" . $_POST['kerusakan'] . "','" . $_POST['id_teknisi'] . "','0')");
  if ($simpan) {
    if ($_POST['status'] == 2) {
      mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set barang_gudang_detail.status_kerusakan=2, barang_gudang.stok_total=barang_gudang.stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['no_seri'] . "");
    } else {
      mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set barang_gudang_detail.status_kerusakan=1, barang_gudang.stok_total=barang_gudang.stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['no_seri'] . "");
    }
    echo "<script>window.location='index.php?page=barang_rusak'</script>";
  }
}

if (isset($_POST['button_urut'])) {
  echo "<script>window.location='cetak_stok_alkes.php?merk=$_POST[merk]'</script>";
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Alkes Rusak</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Alkes Rusak</li>
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
        <div class="box box-body">
          <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
            <?php if (!isset($_SESSION['user_admin_teknisi'])) { ?>
              <button name="tambah_laporan" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-tambah"><span class="fa fa-plus"></span> Tambah</button>
            <?php } ?>
          </div>

          <!--<form method="post" action="cetak_stok_alkes.php">-->

          <div class="pull pull-right">
            <?php //include "include/getFilter.php"; 
            ?>
            <?php include "include/atur_halaman.php"; ?>
          </div>
        </div>

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

      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>