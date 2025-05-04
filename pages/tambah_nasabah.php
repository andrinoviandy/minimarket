<?php
if (isset($_POST['tambah_header'])) {
	$sel = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from nasabah"));
    $eks = explode(".",$_FILES['foto']['name']);
	$foto = ($sel['id_max']+1).".".$eks[1];
	$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from nasabah"));
	if ($cek==0){
	$id=1;
	} else {
	$max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as idd from nasabah"));
	$id=$max['idd'];
	}
	$Result = mysqli_query($koneksi, "insert into nasabah values('$id','$_POST[nik]','$_POST[nama_nasabah]','$_POST[tempat_lahir]','$_POST[tanggal_lahir]','$_POST[alamat]','$_POST[email]','$_POST[no_hp]','1')");
	if ($Result) {
		//copy($_FILES['foto']['tmp_name'],"gambar_foto/foto_nasabah/".($sel['id_max']+1).".".$eks[1]);
		echo "<script type='text/javascript'>
		alert('Data Berhasil Di Simpan !');
		window.location='index.php?page=nasabah'
		</script>";
		}
	}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><span class="active">Tambah Nasabah</span></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Nasabah</li>
        <li class="active">Tambah Nasabah</li>
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
              <h3 class="box-title">Tambah <span class="active">Nasabah</span></h3>
            </div>
              <div class="box-body">
              <form method="post" enctype="multipart/form-data">
              <label>NIK</label>
              <input name="nik" class="form-control" type="text" placeholder="" value="" required autofocus="autofocus"><br />
              <label>Nama Nasabah</label>
              <input name="nama_nasabah" class="form-control" type="text" placeholder="" value="" required="required"><br />
              <label>Tempat Lahir</label>
              <input name="tempat_lahir" class="form-control" type="text" placeholder="" value=""><br />
              <label>Tanggal Lahir</label>
              <input name="tanggal_lahir" class="form-control" type="date" placeholder="" value=""><br />
              <label>Alamat</label>
              <textarea name="alamat" class="form-control" placeholder=""></textarea>
              <br />
              <label>Email</label>
              <input name="email" class="form-control" type="email" placeholder=""><br />
              <label>No. HP</label>
              <input name="no_hp" class="form-control" type="text" placeholder="" value=""><br />
              
              <button name="tambah_header" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </form>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
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
  