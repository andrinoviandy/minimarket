<?php
$q_lunas = mysqli_query($koneksi, "update barang_pesan_set set tgl_masuk_gudang='" . $_POST['tgl_lunas'] . "' where id=$_GET[id]");
if ($q_lunas) {
  echo "<script type='text/javascript'>
  window.location='index.php?page=barang_set1';
  </script>";
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pemesanan Barang</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Barang Set</li>
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
          <span class="pull pull-right">
            <table>
              <tr>
                <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                <td valign="top">1. </td>
                <td valign="top">Tanda "<span class="fa fa-share"></span>" Menandakan Sudah Di Mutasi</td>
              </tr>
            </table>
          </span>
          <br />
          <br />
          <div class="pull pull-right">
            <?php include "include/getFilter.php";
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


<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=jual_barang2&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=jual_barang3&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
  </div>
</div>

<div id="openLunas" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Tgl Masuk Gudang</h3>
    <form method="post">

      <input id="input" value="<?php echo $q2['tgl_masuk_gudang']; ?>" type="date" placeholder="" name="tgl_lunas">
      <button id="buttonn" name="lunasin" type="submit">Simpan</button>
    </form>
  </div>
</div>

<div class="modal fade" id="modal-tglmasuk">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tanggal Masuk Gudang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <input type="hidden" name="id_tgl" id="id_tgl" />
          <input id="tgl_lunas" type="date" class="form-control" name="tgl_lunas">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="lunasin" type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function simpanTgl(id, tgl) {
    document.getElementById("id_tgl").value = id
    document.getElementById("tgl_lunas").value = tgl
    $('#modal-tglmasuk').show('modal');
  }
</script>