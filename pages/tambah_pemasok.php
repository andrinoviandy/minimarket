<?php
if (isset($_POST['tambah_header'])) {
  $stmt = $koneksi->prepare("
        INSERT INTO supplier (
            nama_supplier, alamat_supplier, telp_supplier, fax_supplier, attn_supplier
        )
        VALUES (?, ?, ?, ?, ?)
        ");
  $params = [$_POST['nama_pemasok'], $_POST['alamat'], $_POST['telp'], $_POST['fax'], $_POST['attn']];
  $types = getBindTypes($params);
  $stmt->bind_param($types, ...$params);
  $Result = $stmt->execute();
  if ($Result) {
    echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-green',
          cancelButton: 'bg-white',
        },
        title: 'Data Berhasil Disimpan !',
        icon: 'success',
        confirmButtonText: 'OK',
        allowOutsideClick: false
      }).then((result) => {
        window.location.href = '?page=pemasok';
      })
      </script>";
  } else {
    echo "<script>
      Swal.fire({
        customClass: {
          confirmButton: 'bg-red',
          cancelButton: 'bg-white',
        },
        title: 'Data Gagal Disimpan !',
        icon: 'success',
        confirmButtonText: 'OK',
        allowOutsideClick: false
      }).then((result) => {
        history.back();
      })
      </script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><span class="active">Tambah Supplier</span></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Supplier</li>
      <li class="active">Tambah Supplier</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-5 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah <span class="active">Supplier</span></h3>
            </div>
            <div class="box-body">
              <form method="post">
                <label>Nama Supplier</label>
                <input name="nama_pemasok" class="form-control" type="text" placeholder="" value=""><br />
                <label>Alamat</label>
                <textarea name="alamat" class="form-control"></textarea><br />
                <label>Telepon</label>
                <input name="telp" class="form-control" type="text" placeholder=""><br />
                <label>Fax.</label>
                <input name="fax" class="form-control" type="text" placeholder=""><br />
                <label>Pemilik</label>
                <input name="attn" class="form-control" type="text" placeholder=""><br />
                <button name="tambah_header" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
              </form>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">

        <!-- Map box --><!-- /.box -->

        <!-- solid sales graph --><!-- /.box -->

        <!-- Calendar --><!-- /.box -->

      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>