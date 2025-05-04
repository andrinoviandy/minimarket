<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Nasabah</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Nasabah</li>
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
                <a href="index.php?page=tambah_nasabah">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
              </div>
              <div class="pull pull-right">
                <?php //include "include/getFilter.php"; ?>
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
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->

      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<?php
if (isset($_POST['ubahbukti'])) {
  $qq = mysqli_fetch_array(mysqli_query($koneksi, "select * from karyawan where id=" . $_GET['id_bukti'] . ""));
  unlink("gambar_foto/foto_karyawan/$qq[foto]");

  $ext2 = explode(".", $_FILES['foto']['name']);
  $lamp_f = $_GET['id_bukti'] . "." . $ext2[1];

  $u2 = mysqli_query($koneksi, "update karyawan set foto='" . $lamp_f . "' where id=" . $_GET['id_bukti'] . "");
  if ($u2) {
    copy($_FILES['foto']['tmp_name'], "gambar_foto/foto_karyawan/" . $lamp_f);
    echo "<script type='text/javascript'>
		alert('Berhasil Di Ubah !');
		window.location='index.php?page=karyawan';
		</script>";
  }
}
?>
<div id="ubah_bukti" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Foto</h3>
    <form method="post" enctype="multipart/form-data">
      <input name="foto" type="file" class="form-control" />
      <br />
      <button name="ubahbukti" class="form-control btn btn-success" type="submit">Simpan</button>
      <br />
    </form>
    </form>

  </div>
</div>

<script>
  async function hapusData(id) {
    const confirm = await alertConfirm('Apakah Anda Yakin Menghapus Data Ini ?', 'Data Tidak Dapat Dikembalikan')
    if (confirm) {
      $.post("data/hapus-nasabah.php", {id: id},
        function (data, textStatus, jqXHR) {
          if (data == 'S') {
            alertHapus('S')
            loadMore(load_flag, key, status_b);
          } else {
            alertHapus('F')
          }
        }
      );
    }
  }
</script>