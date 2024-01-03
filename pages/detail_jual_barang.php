<?php
if (isset($_POST['pencarian'])) {
  if ($_POST['pilihan'] == 'tgl_jual') {
    echo "<script>window.location='index.php?page=detail_jual_barang&id=$_GET[id]&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]'</script>";
  } else {
    echo "<script>window.location='index.php?page=detail_jual_barang&id=$_GET[id]&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]'</script>";
  }
}

if (isset($_GET['id_b_s'])) {
  $q = mysqli_query($koneksi, "update barang_dikirim set tgl_sampai='' where id=" . $_GET['id_b_s'] . "");
  if ($q) {
    echo "<script>window.location='index.php?page=kirim_barang'</script>";
  }
}
if (isset($_GET['id_hapus'])) {
  $q1 = mysqli_query($koneksi, "update barang_dikirim,barang_dikirm_detail,barang_gudang_detail set barang_gudang_detail.status_kirim=0 where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim.id=" . $_GET['id_hapus'] . "");
  //$q2 = mysqli_query($koneksi, "select * from barang_dikirim,barang_dikirm_detail,barang_gudang_detail,barang_gudang where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim.id=".$_GET['id_hapus']."");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Detail Pengiriman Alkes
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Detail Pengiriman Alkes</li>
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
                <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
                  <a href="index.php?page=jual_barang">
                    <button class="btn btn-warning pull pull-left"><span class="fa fa-arrow-left"></span> Kembali</button>
                  </a>
                </div>
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
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

<div class="modal fade" id="modal-detailbarang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="data-detail-jual-barang"></div>
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
<script>
  function modalDetailBarang(param) {
    $.get("data/data-detail-jual-barang.php", {
      id: param
    },
      function (data) {
        $('#data-detail-jual-barang').html(data);
        $('#modal-detailbarang').modal('show'); 
      }
    );
  }
</script>