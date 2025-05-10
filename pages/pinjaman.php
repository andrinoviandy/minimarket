<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Pinjaman</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pinjaman</li>
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
              <div class="input-group pull pull-left">
                <button name="tambah_laporan" class="btn btn-success" style="margin-right: 10px;" type="button" onclick="modalPinjam(); return false"><span class="fa fa-minus"></span>&nbsp; Pinjam</button>
                <button name="tambah_laporan" class="btn btn-info" style="margin-right: 10px;" type="button" onclick="modalBayar(); return false"><span class="fa fa-plus"></span>&nbsp; Bayar</button>
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

<div class="modal fade" id="modal-pinjam" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buat Data Pinjaman</h4>
      </div>
      <form method="post" onsubmit="simpanPinjam(); return false;" id="formPinjam">
        <div class="modal-body">
          <div id="data-pinjam"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-bayar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Bayar Pinjaman</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanBayar(); return false;" id="formBayar">
        <div class="modal-body">
          <div id="data-modal-bayar"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan_setor">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  async function hapusData(id) {
    const confirm = await alertConfirm('Apakah Anda Yakin Menghapus Data Ini ?', 'Data Tidak Dapat Dikembalikan')
    if (confirm) {
      $.post("data/hapus-nasabah.php", {
          id: id
        },
        function(data, textStatus, jqXHR) {
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

  async function modalPinjam() {
    await $.get("data/modal-pinjam.php",
      function(data, textStatus, jqXHR) {
        $('#data-pinjam').html(data);
      }
    );
    $('#modal-pinjam').modal('show');
  }

  function simpanPinjam() {
    var dataform = $('#formPinjam')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-pinjaman.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response === 'S') {
          $('#modal-pinjam').modal('hide');
          dataform.reset();
          alertSimpan('S')
          loadMore(load_flag, key, status_b)
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  async function modalBayar() {
    await $.get("data/modal-bayar-pinjaman.php",
      function(data, textStatus, jqXHR) {
        $('#data-modal-bayar').html(data);
      }
    );
    $('#modal-bayar').modal('show');
  }

  function simpanBayar() {
    var dataform = $('#formBayar')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-bayar-pinjaman.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response === 'S') {
          $('#modal-bayar').modal('hide');
          dataform.reset();
          alertSimpan('S')
          loadMore(load_flag, key, status_b)
        } else {
          alertSimpan('F')
        }
      }
    });
  }
</script>