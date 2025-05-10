<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from nasabah where id='" . $_GET['id_ubah'] . "'"));
if (isset($_POST['tambah_header'])) {
    $Result = mysqli_query($koneksi, "update nasabah set nik='$_POST[nik]',nama_nasabah='$_POST[nama_nasabah]',tempat_lahir='$_POST[tempat_lahir]',tanggal_lahir='$_POST[tanggal_lahir]',alamat='$_POST[alamat]',no_hp='$_POST[no_hp]',email='$_POST[email]' where id=$_GET[id_ubah]");
    if ($Result) {
        echo "<script type='text/javascript'>
		alert('Data Berhasil Di Ubah !');
		window.location='index.php?page=nasabah'
		</script>";
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><span class="active">Ubah Nasabah</span></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Nasabah</li>
            <li class="active">Ubah Nasabah</li>
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
                            <h3 class="box-title">Ubah <span class="active">Nasabah</span></h3>
                        </div>
                        <div class="box-body">
                            <form method="post">
                                <label>NIK</label>
                                <input name="nik" class="form-control" type="text" placeholder="" value="<?php echo $data['nik']; ?>" required autofocus="autofocus"><br />
                                <label>Nama nasabah</label>
                                <input name="nama_nasabah" class="form-control" type="text" placeholder="" value="<?php echo $data['nama_nasabah']; ?>" required="required"><br />
                                <label>Tempat Lahir</label>
                                <input name="tempat_lahir" class="form-control" type="text" placeholder="" value="<?php echo $data['tempat_lahir']; ?>"><br />
                                <label>Tanggal Lahir</label>
                                <input name="tanggal_lahir" class="form-control" type="date" placeholder="" value="<?php echo $data['tanggal_lahir']; ?>"><br />
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" placeholder=""><?php echo $data['alamat']; ?></textarea>
                                <br />
                                <label>Email</label>
                                <input name="email" class="form-control" type="email" placeholder="" value="<?php echo $data['email']; ?>"><br />
                                <label>No. HP</label>
                                <input name="no_hp" class="form-control" type="text" placeholder="" value="<?php echo $data['no_hp']; ?>">
                                <br />
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
            <section class="col-lg-6 connectedSortable"></section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>