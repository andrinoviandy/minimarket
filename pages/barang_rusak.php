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
              <button name="tambah_laporan" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-tambah" onclick="getNamaBarang();"><span class="fa fa-plus"></span> Tambah</button>
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

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Barang Rusak</h4>
      </div>
      <form id="formUbah" onsubmit="inputBarangRusak(); return false;">
      <!-- <form> -->
        <div class="modal-body">
          <div class="form-group">
            <label>Tanggal Input</label>
            <input id="" name="tgl_input" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" />
          </div>
          <div class="form-group">
            <label>Nama Alkes</label>
            <div id="nama_barang"></div>
          </div>
          <div class="form-group">
            <label>No Seri</label>
            <div id="no_seri">
              <select disabled class="form-control"></select>
            </div>
          </div>
          <label>Deskripsi Kerusakan</label>
          <textarea class="form-control" rows="3" name="kerusakan"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  async function getNamaBarang() {
    $('#nama_barang').html('<center><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></center>');
    await $.get("data/get_data_barang.php",
      function(data) {
        $('#nama_barang').html(data);
      }
    );
  }

  async function changeBarang(id) {
    $('#no_seri').html('<center><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></center>');
    await $.get("data/get_data_no_seri.php", {
        id: id
      },
      function(data) {
        $('#no_seri').html(data);
      }
    );
  }

  async function inputBarangRusak() {
    showLoading(1)
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    await $.ajax({
      type: "post",
      url: "data/simpan-barang-rusak-belum-terjual.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        showLoading(0)
        if (response == 'S') {
          $('#modal-tambah').modal('hide');
          dataform.reset();
          loading()
          loadMore(load_flag, key, status_b)
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }
</script>