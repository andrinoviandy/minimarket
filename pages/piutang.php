<?php
if (isset($_POST['pencarian'])) {
  // if ($_POST['pilihan'] == 'tgl_input') {
  echo "<script>window.location='index.php?page=piutang&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]'</script>";
  // } else {
  //   echo "<script>window.location='index.php?page=piutang&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]'</script>";
  // }
}

if (isset($_POST['button_urut'])) {
  echo "<script>window.location='cetak_stok_alkes.php?merk=$_POST[merk]'</script>";
}
?>
<?php
if (isset($_GET['id_hapus'])) {
  $del = mysqli_query($koneksi, "delete from utang_piutang where id=" . $_GET['id_hapus'] . "");
  if (!$del) {
    echo "<script>
		alert('Maaf , Data Tidak Dapat Di Hapus Karena Masih Ada Detail Pembayaran');
		</script>";
  }
}

if (isset($_GET['id_batal'])) {
  $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from utang_bayar where utang_id=$_GET[id_batal]"));

  $del = mysqli_query($koneksi, "delete from utang where id=" . $_GET['id_hapus'] . "");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Piutang</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Piutang</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12">
        <div class="box box-body">

          <div class="pull pull-right">
            <?php include "include/getFilter.php"; ?>
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
<div class="modal fade" id="modal-detail-barang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <div class="modal-body">
        <div id="modal-data-barang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function modalDetailBarang(id) {
    $('#modal-detail-barang').modal('show');
    $.get("data/modal-detail-barang.php", {
        id: id
      },
      function(data) {
        $('#modal-data-barang').html(data)
      }
    );
  }
</script>