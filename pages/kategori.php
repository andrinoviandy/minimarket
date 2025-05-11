<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Akun COA
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">COA</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <form method="post" enctype="multipart/form-data">
      <div class="row">
        <!-- Left col -->
        <div id="data-neraca"></div>
        <div id="data-laba"></div>
        <!-- right col -->
      </div>
    </form>
    <!-- /.row (main row) -->
  <!-- /.content -->
</div>

<div class="modal fade" id="modal-grup-neraca">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Grup - Neraca</h4>
      </div>
      <form id="formGrupNeraca" onsubmit="simpanGrupNeraca(); return false;">
        <div class="modal-body">
          <label>Grup</label>
          <select name="coa_id" required class="form-control select2" style="width:100%">
            <option value="">...</option>
            <?php
            $q_coa = mysqli_query($koneksi, "select * from coa where id between 1 and 3 order by nama_grup ASC");
            while ($d_coa = mysqli_fetch_array($q_coa)) {
            ?>
              <option value="<?php echo $d_coa['id']; ?>"><?php echo $d_coa['nama_grup']; ?></option>
            <?php
            }
            ?>
          </select>
          <br><br>
          <label>Nama</label>
          <input name="nama_sub_grup" required type="text" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-grup-laba">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Grup - Neraca</h4>
      </div>
      <form id="formGrupLaba" onsubmit="simpanGrupLaba(); return false;">
        <div class="modal-body">
          <label>Grup</label>
          <select name="coa_id" required class="form-control select2" style="width:100%">
            <option value="">...</option>
            <?php
            $q_coa2 = mysqli_query($koneksi, "select * from coa where id between 4 and 5 order by nama_grup ASC");
            while ($d_coa = mysqli_fetch_array($q_coa2)) {
            ?>
              <option value="<?php echo $d_coa['id']; ?>"><?php echo $d_coa['nama_grup']; ?></option>
            <?php
            }
            ?>
          </select>
          <br><br>
          <label>Nama</label>
          <input name="nama_sub_grup" required type="text" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-akun-neraca">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Akun - Neraca</h4>
      </div>
      <form id="formAkunNeraca" onsubmit="simpanAkunNeraca(); return false;">
        <div class="modal-body">
          <div id="form-data-neraca"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-akun-laba">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Akun - Neraca</h4>
      </div>
      <form id="formAkunLaba" onsubmit="simpanAkunLaba(); return false;">
        <div class="modal-body">
          <div id="form-data-laba"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function getNeraca() {
    $.get("data/neraca.php",
      function(data) {
        $('#data-neraca').html(data);
      }
    );
  }

  function getLaba() {
    $.get("data/laba-rugi.php",
      function(data) {
        $('#data-laba').html(data);
      }
    );
  }

  function getFormNeraca() {
    $.get("data/form-akun-neraca.php",
      function (data) {
       $('#form-data-neraca').html(data); 
      }
    );
  }
  function getFormLaba() {
    $.get("data/form-akun-laba.php",
      function (data) {
       $('#form-data-laba').html(data); 
      }
    );
  }

  function simpanGrupNeraca() {
    var dataform = $('#formGrupNeraca')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-grup-neraca.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getNeraca();
          alertSimpan('S');
          $('#modal-grup-neraca').modal('hide');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanGrupLaba() {
    var dataform = $('#formGrupLaba')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-grup-neraca.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getLaba();
          alertSimpan('S');
          $('#modal-grup-laba').modal('hide');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanAkunNeraca() {
    var dataform = $('#formAkunNeraca')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-akun-neraca.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getNeraca();
          alertSimpan('S');
          $('#modal-akun-neraca').modal('hide');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanAkunLaba() {
    var dataform = $('#formAkunLaba')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-akun-neraca.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getLaba();
          alertSimpan('S');
          $('#modal-akun-laba').modal('hide');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function hapus2(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Yakin Akan Menghapus COA Ini ?',
      text: 'Proses ini akan berhasil jika COA Ini Belum Digunakan !',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-coa2.php", {
            hapus_aset: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              getNeraca();
              getLaba();
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }

  function hapus3(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Yakin Akan Menghapus COA Ini ?',
      text: 'Proses ini akan berhasil jika COA Ini Belum Digunakan !',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-coa3.php", {
            hapus_sub_akun: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              getNeraca();
              getLaba();
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }

  $(document).ready(function() {
    getLaba();
    getNeraca();
  });
</script>