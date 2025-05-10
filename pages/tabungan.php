<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Tabungan</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tabungan</li>
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
                <button name="tambah_laporan" class="btn btn-success" style="margin-right: 10px;" type="button" onclick="modalBukaTabungan(); return false"><span class="fa fa-plus"></span>&nbsp; Buka Tabungan</button>
                <button name="tambah_laporan" class="btn btn-info" style="margin-right: 10px;" type="button" onclick="modalSetor(); return false"><span class="fa fa-plus"></span>&nbsp; Setor</button>
                <button name="tambah_laporan" class="btn btn-danger" type="button" onclick="modalAmbil(); return false"><span class="fa fa-minus"></span>&nbsp; Ambil</button>
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

<div class="modal fade" id="modal-buka-tabungan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buka Tabungan Baru</h4>
      </div>
      <form method="post" onsubmit="simpanTabungan(); return false;" id="formTabungan">
        <div class="modal-body">
          <div id="data-buka-tabungan"></div>
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

<div class="modal fade" id="modal-setor">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Setor Tabungan</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanSetor(); return false;" id="formSetor">
        <div class="modal-body">
          <div id="data-modal-setor"></div>
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

<div class="modal fade" id="modal-ambil">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ambil Tabungan</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanAmbil(); return false;" id="formAmbil">
        <div class="modal-body">
          <div id="data-modal-ambil"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan_ambil">Simpan</button>
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

  async function modalBukaTabungan() {
    await $.get("data/modal-buka-tabungan.php",
      function(data, textStatus, jqXHR) {
        $('#data-buka-tabungan').html(data);
      }
    );
    $('#modal-buka-tabungan').modal('show');
  }

  function simpanTabungan() {
    var dataform = $('#formTabungan')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-tabungan.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response === 'S') {
          $('#modal-buka-tabungan').modal('hide');
          dataform.reset();
          alertSimpan('S')
          loadMore(load_flag, key, status_b)
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  async function modalSetor() {
    await $.get("data/modal-setor.php",
      function(data, textStatus, jqXHR) {
        $('#data-modal-setor').html(data);
      }
    );
    $('#modal-setor').modal('show');
  }

  function simpanSetor() {
    var dataform = $('#formSetor')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-setor-ambil.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response === 'S') {
          $('#modal-setor').modal('hide');
          dataform.reset();
          alertSimpan('S')
          loadMore(load_flag, key, status_b)
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  async function modalAmbil() {
    await $.get("data/modal-ambil.php",
      function(data, textStatus, jqXHR) {
        $('#data-modal-ambil').html(data);
      }
    );
    $('#modal-ambil').modal('show');
  }

  function simpanAmbil() {
    var dataform = $('#formAmbil')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-setor-ambil.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response === 'S') {
          $('#modal-ambil').modal('hide');
          dataform.reset();
          alertSimpan('S')
          loadMore(load_flag, key, status_b)
        } else if (response === 'F') {
          alertSimpan('F')
        } else {
          let resp = response.split("&")
          console.log(resp, 'resp');
          
          alertCustom('F', 'Data Gagal Disimpan !', 'Saldo Kurang ' + resp[1])
        }
      }
    });
  }
</script>