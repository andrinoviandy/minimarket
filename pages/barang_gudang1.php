<?php

if (isset($_GET['id_tgl'])) {
  $q_lunas = mysqli_query($koneksi, "update barang_pesan set tgl_masuk_gudang='" . $_GET['tgl'] . "' where id=$_GET[id_tgl]");
  if ($q_lunas) {
    echo "<script type='text/javascript'>
		window.location='index.php?page=barang_gudang1';
		</script>";
  }
}

if (isset($_POST['lihat'])) {
  echo "<script>
	window.location='index.php?page=barang_gudang1&tgldari=$_POST[tgl1]&tglsampai=$_POST[tgl2]&mutasi=$_POST[mutasi]';
	</script>";
}

if (isset($_POST['print'])) {
  echo "<script>
	window.open('print_barang_gudang1.php&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&mutasi=$_POST[mutasi]', '_blank');
	</script>";
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php if (isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_manajer_gudang'])) { ?>
        Gudang 1
      <?php } else if (isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_manajer_keuangan'])) {
        echo "Pembelian";
      } else {
        echo "Gudang 1 / Pembelian";
      } ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Alkes</li>
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
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                  <i class="fa fa-eye"></i> Lihat
                </button>
                <?php if (isset($_GET['mutasi'])) { ?>
                  <a href="index.php?page=barang_gudang1"><button class="btn btn-warning">Reset</button></a>
                <?php } ?>
                <span class="pull pull-right">
                  <table>
                    <tr>
                      <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Tanda "<span class="fa fa-share"></span>" Menandakan Sudah Di Mutasi ke Gudang Utama / Gudang 2</td>
                    </tr>
                  </table>
                </span>
                <br />
                <div class="pull pull-right">
                  <?php include "include/getFilter.php"; ?>
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
              <div class="">
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
              <br />

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


<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=jual_barang2&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=jual_barang3&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
  </div>
</div>

<section class="col-lg-2">
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Lihat</h4>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <label>Dari Tanggal</label>
            <input type="date" name="tgl1" class="form-control" />
            <br />
            <label>Sampai Tanggal</label>
            <input type="date" name="tgl2" class="form-control" />
            <br />
            <label>Mutasi</label>
            <select name="mutasi" class="form-control select2" style="width:100%" required>
              <option value="">...</option>
              <option value="0">Belum Mutasi</option>
              <option value="1">Sudah Mutasi</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" name="lihat" class="btn btn-primary">Lihat</button>
            <!--<button type="submit" name="print" class="btn btn-info">Print</button>-->
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</section>
<script>
  let tgl_masuk = '';
  function ubahTgl(tgl) {
    tgl_masuk = tgl
  }
  function simpanTgl(id) {
    window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_tgl=' + id + '&tgl=' + tgl_masuk;
  }
</script>