<?php
if (isset($_POST['tambah_laporan'])) {
  mysqli_begin_transaction($koneksi);
  $stmt = $koneksi->prepare("
        INSERT INTO admin (
            nama, username, password, email, no_wa, role_id
        )
        VALUES (?, ?, ?, ?, ?, ?)
        ");
  $params = [$_POST['nama'], $_POST['username'], md5($_POST['password']), $_POST['email'], $_POST['no_wa'], $_POST['role_id']];
  $types = getBindTypes($params);
  $stmt->bind_param($types, ...$params);
  $Result = $stmt->execute();
  if ($Result) {
    mysqli_commit($koneksi);
    echo "<script type='text/javascript'>
		Swal.fire('Data Berhasil Disimpan');
        window.location='index.php?page=user';
		</script>";
  } else {
    mysqli_rollback($koneksi);
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah User Baru
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="index.php?page=barang_masuk">Produk</a></li>
      <li class="active">Tambah User Baru</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-6 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah User Baru</h3>
            </div>
            <div class="box-body">
              <form method="post">
                <div class="form-group">
                  <label>Role</label>
                  <select name="role_id" class="form-control select2" required style="width:100%">
                    <option value="">...</option>
                    <?php
                    $query = mysqli_query($koneksi, "select * from role");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                      <option value="<?php echo $data['id']; ?>"><?php echo $data['nama_role']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input name="nama" class="form-control" type="text" placeholder="" required>
                </div>
                <div class="form-group">
                  <label>Username</label>
                  <input name="username" class="form-control" type="text" placeholder="" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input name="password" class="form-control" type="password" placeholder="" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input name="email" class="form-control" type="email" placeholder="" required>
                </div>
                <div class="form-group">
                  <label>No. WA</label>
                  <input name="no_wa" class="form-control" type="text" placeholder="" required>
                </div>
                <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
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