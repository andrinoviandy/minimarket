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
              <div class="input-group pull pull-left" style="padding-right:10px">
                <button name="tambah_laporan" class="btn btn-success" style="margin-right: 10px;" type="button" onclick="modalSetor(); return false"><span class="fa fa-plus"></span>&nbsp; Setor</button>
                <button name="tambah_laporan" class="btn btn-success" type="button" onclick="modalAmbil(); return false"><span class="fa fa-minus"></span>&nbsp; Ambil</button>
              </div>
              <div class="pull pull-right">
                <?php include "include/getFilter.php"; ?>
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

<div class="modal fade" id="modal-setor">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Setor Tabungan</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select class="form-control select2" name="pilihan" required style="width:100%">
            <option value="">...</option>
          </select>
          <br /><br />
          <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
          <br />
          <select name="tampil" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <option value="1">Tampilkan Detail Barang</option>
            <option value="0">Tidak Tampilkan Detail Barang</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Cari</button>
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
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select class="form-control select2" name="pilihan" required style="width:100%">
            <option value="">...</option>
          </select>
          <br /><br />
          <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
          <br />
          <select name="tampil" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <option value="1">Tampilkan Detail Barang</option>
            <option value="0">Tidak Tampilkan Detail Barang</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Cari</button>
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

  async function modalSetor() {
    // await $.get("data/option-tabungan.php",
    //   function(data, textStatus, jqXHR) {
    //     $('#data-nasabah').html(data);
    //   }
    // );
    $('#modal-setor').modal('show');
  }

  async function modalAmbil() {
    // await $.get("data/option-tabungan.php",
    //   function(data, textStatus, jqXHR) {
    //     $('#data-nasabah').html(data);
    //   }
    // );
    $('#modal-ambil').modal('show');
  }
</script>