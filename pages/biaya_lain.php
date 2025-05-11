<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Penerimaan &amp; Pembayaran Lain</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Biaya Lain</li>
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
                <!-- <a href="index.php?page=tambah_biaya_lain"> -->
                <button name="tambah_laporan" class="btn btn-success" data-toggle="modal" data-target="#modal-tambah"><span class="fa fa-plus"></span> Tambah</button>
                <!-- </a> -->
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

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Transaksi</h4>
      </div>
      <form id="formTambah" onsubmit="tambahData(); return false;">
        <div class="modal-body">
          <label>Jenis Transaksi</label>
          <select required name="jenis_transaksi" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <option value="Penerimaan">Penerimaan</option>
            <option value="Pembayaran">Pembayaran</option>
          </select>
          <br /><br />
          <label>Tanggal</label>
          <input name="tanggal" class="form-control" type="date" placeholder="" value="" required="required"><br />
          <label>Akun Bank / Kas</label>
          <select name="buku_kas_id" class="form-control select2" style="width:100%" required>
            <option value="">...</option>
            <?php $query = mysqli_query($koneksi, "SELECT id,nama_akun FROM buku_kas");
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_akun']; ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label>Diterima Oleh / Diterima Dari</label>
          <input name="penerima" class="form-control" type="text" placeholder=""><br />
          <label>Akun COA</label>
          <div class="well">
            <select required name="coa_id" class="form-control select2" id="coa_id" onchange="pilih2(this.value)" style="width: 100%;">
              <option value="">...</option>
              <?php $query1 = mysqli_query($koneksi, "SELECT * FROM coa");
              while ($row1 = mysqli_fetch_array($query1)) {
              ?>
                <option value="<?php echo $row1['id'] ?>"><?php echo $row1['nama_grup']; ?></option>
              <?php } ?>
            </select>
            <br /><br />
            <div id="pilih2">
              <select required name="coa_sub_id2" class="form-control select2" id="coa_sub_id2" style="width: 100%;">
                <option value="">...</option>
              </select>
            </div>
            <br />
            <div id="pilih3">
              <select name="coa_sub_akun_id2" class="form-control select2" style="width:100%" id="coa_sub_akun_id2">
                <option value="">...</option>
              </select>
            </div>
            <!-- <script src="jquery-1.10.2.min.js"></script> -->
            <!-- <script src="jquery.chained.min.js"></script>
            <script>
              $("#coa_sub_id").chained("#coa_id");
              $("#coa_sub_akun_id").chained("#coa_sub_id");
            </script> -->
          </div>
          <label>Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="4"></textarea><br />
          <label>Harga</label>
          <input name="harga" class="form-control" type="text" placeholder="" value="" required="required" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ubah Data Transaksi</h4>
      </div>
      <form id="formUbah" onsubmit="ubahData(); return false;">
        <div class="modal-body">
          <div id="form-data"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function pilih2(id) {
    $.get("data/pilih2.php", {
        id: id
      },
      function(data) {
        $('#pilih2').html(data);
      }
    );
  }
  function pilih3(id) {
    $.get("data/pilih3.php", {
        id: id
      },
      function(data) {
        $('#pilih3').html(data);
      }
    );
  }

  function openUbah(id) {
    $.get("data/form-ubah-biaya-lain.php", {
        id_ubah: id
      },
      function(data) {
        $('#form-data').html(data);
        $('#modal-ubah').modal('show');
      }
    );
  }

  function ubahData() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/ubah-biaya-lain.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          loadMore(load_flag, key, status_b)
          $('#modal-ubah').modal('hide')
          alertSimpan('S')
        } else if (response == 'K') {
          alertCustom('F', 'Gagal Disimpan !', 'Saldo Pada Buku Kas Ini Kurang Dari Nominal Yang Di Masukkan, Silakan Tambah Saldo Atau Gunakan Buku Kas Lain !')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function tambahData() {
    var dataform = $('#formTambah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/tambah-biaya-lain.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          loadMore(load_flag, key, status_b)
          $('#modal-tambah').modal('hide')
          alertSimpan('S')
        } else if (response == 'K') {
          alertCustom('F', 'Gagal Disimpan !', 'Saldo Pada Buku Kas Ini Kurang Dari Nominal Yang Di Masukkan, Silakan Tambah Saldo Atau Gunakan Buku Kas Lain !')
        } else {
          alertSimpan('F')
        }
      }
    });
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
        $.post("data/hapus-biaya-lain.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              loadMore(load_flag, key, status_b)
            } else if (data == 'TC') {
              alertCustom('W','Tidak Dapat Dilanjutkan !', 'Saldo untuk pengembalian tidak cukup')
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }
</script>