<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Rekening Bank</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Rekening Bank</li>
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
                <a href="index.php?page=tambah_buku_bank">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
              </div>
              <br /><br><br>
              <div id="table-data">
              </div>
              <br />

            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

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

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ubah Akun</h4>
      </div>
      <form method="post" id="formData" enctype="multipart/form-data" onsubmit="update(); return false;">
        <div class="modal-body">
          <div id="modal-data-buku-bank"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="tambah_laporan" type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=jual_barang2&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=jual_barang3&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
  </div>
</div>

<script>
  function getData() {
    $.get("data/buku_bank.php",
      function(data) {
        $('#table-data').html(data);
      }
    );
  }

  async function modalUbah(id) {
    const res = await $.get("data/modal-data-buku-bank.php", {
        id: id
      },
      function(data, textStatus, jqXHR) {
        $('#modal-data-buku-bank').html(data);
      }
    );
    $('#modal-ubah').modal('show');
  }

  function update() {
    var dataform = $('#formData')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/update-buku-bank.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          alertSimpan('S');
        } else {
          alertSimpan('F')
        }
        getData();
        $('#modal-ubah').modal('hide');
      }
    });
  }

  async function hapus(id) {
    const confirm = await alertConfirm('Anda Yakin Ingin Menghapus Data Ini ?', 'History Pada Kas Ini Juga Akan Terhapus !');
    if (confirm) {
      $.post("data/hapus-buku-bank.php", {
          id_hapus: id
        },
        function(data, textStatus, jqXHR) {
          if (data === 'S') {
            alertHapus('S')
          } else {
            alertHapus('F')
          }
          getData()
        }
      );
    }
  }

  $(document).ready(function() {
    getData()
  });
</script>