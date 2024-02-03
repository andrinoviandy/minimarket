<?php
if (isset($_POST['kirim_barang'])) {
  mysqli_query($koneksi, "delete from barang_demo_kirim_detail_hash where akun_id=" . $_SESSION['id'] . "");
  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_peng'];
  $_SESSION['ekspedisi'] = $_POST['ekspedisi'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['via_pengiriman'] = $_POST['via_kirim'];
  $_SESSION['estimasi'] = $_POST['estimasi_brg_sampai'];
  $_SESSION['biaya_kirim'] = $_POST['biaya_kirim'];
  $_SESSION['no_po'] = $_POST['no_po'];
  $_SESSION['keterangan'] = str_replace("\n", "<br>", $_POST['keterangan']);
  echo "<script type='text/javascript'>
		window.location='index.php?page=pilih_no_seri_demo&id=" . $_POST['id_kirim'] . "';
		</script>";
}

if (isset($_GET['id_ubah'])) {
  $sel = mysqli_query($koneksi, "select * from barang_demo_detail where barang_demo_id=" . $_GET['id_ubah'] . "");
  while ($d = mysqli_fetch_array($sel)) {
    $up_stok = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total+1,status_demo=0 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $d['barang_gudang_detail_id'] . "");
  }
  if ($up_stok) {
    mysqli_query($koneksi, "update barang_demo set status=1 where id=" . $_GET['id_ubah'] . "");
    echo "<script type='text/javascript'>
		window.location='index.php?page=barang_demo';
		</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Barang Demo</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
                <?php if (isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_administrator'])) { ?>
                  <a href="index.php?page=tambah_brg_demo">
                    <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah </button></a>
                <?php } ?>
                <div class="pull pull-right">
                  <?php include "include/getFilter.php"; ?>
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

<div class="modal fade" id="modal-kirim">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Kirim Barang Demo</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <p align="justify">
            <input type="hidden" name="id_kirim" id="id_kirim" />
            <label>Nama Paket</label>
            <input id="input" type="text" placeholder="" name="nama_paket" required>
            <label>No. Surat Jalan</label>
            <input id="input" type="text" placeholder="" name="no_peng" required>
            <label>Ekspedisi</label>
            <input id="input" type="text" placeholder="" name="ekspedisi" required>
            <label>Tanggal Pengiriman</label>
            <input id="input" type="date" placeholder="" name="tgl_kirim" required>
            <label>Via Pengiriman</label>
            <input id="input" type="text" placeholder="" name="via_kirim" required>
            <label>Estimasi Barang Sampai</label>
            <input id="input" type="date" placeholder="" name="estimasi_brg_sampai">
            <label>Biaya Jasa</label>
            <input id="input" type="text" placeholder="" name="biaya_kirim" required="required">
            <label>Keterangan</label>
            <textarea name="keterangan" id="input" rows="4"></textarea>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="kirim_barang" type="submit" class="btn btn-success">Next</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
  function modalKirim(id) {
    $('#id_kirim').val(id);
    $('#modal-kirim').modal('show');
  }

  function hapus(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        // window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id;
        $.post("data/hapus-barang-demo.php", {
            id: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S')
              loadMore(load_flag, key, status_b)
            } else {
              alertCustom('F', 'Data Tidak Dapat Dihapus !', 'Data Sedang Digunakan');
            }
          }
        );
      }
    })
  }
</script>