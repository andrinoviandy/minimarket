<?php
if (isset($_GET['id_hapus'])) {
  $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from biaya_lain where id=$_GET[id_hapus]"));
  if ($sel['jenis_transaksi'] == 'Pembayaran') {
    $up = mysqli_query($koneksi, "update biaya_lain,buku_kas set saldo=saldo+$sel[harga] where buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.buku_kas_id=" . $sel['buku_kas_id'] . "");
  } else {
    $up = mysqli_query($koneksi, "update biaya_lain,buku_kas set saldo=saldo-$sel[harga] where buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.buku_kas_id=" . $sel['buku_kas_id'] . "");
  }
  if ($up) {
    $de = mysqli_query($koneksi, "delete from biaya_lain where id=$_GET[id_hapus]");
    $de2 = mysqli_query($koneksi, "delete from keuangan_detail where keuangan_id=$sel[keuangan_id]");
    $de3 = mysqli_query($koneksi, "delete from keuangan where id=$sel[keuangan_id]");
    if ($de) {
      echo "<script>
	alert('Data Berhasil Dihapus !');
	window.location='index.php?page=biaya_lain'</script>";
    } else {
      echo "<script>
	alert('Data Gagal Dihapus !');
	window.location='index.php?page=biaya_lain'</script>";
    }
  }
}
?>
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
                <a href="index.php?page=tambah_biaya_lain">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
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
<?php
$da = mysqli_fetch_array(mysqli_query($koneksi, "select *,buku_kas.id as ide from biaya_lain,buku_kas,pilihan_biaya where buku_kas.id=biaya_lain.buku_kas_id and biaya_lain.pilihan_biaya_id=pilihan_biaya.id and biaya_lain.id=$_GET[id_ubah]"));

if (isset($_POST['ubah_riwayat'])) {
  $up = mysqli_query($koneksi, "update buku_kas set saldo=saldo+$da[harga] where buku_kas.id=$da[ide]");
  if ($up) {
    $up2 = mysqli_query($koneksi, "update buku_kas set saldo=saldo-$_POST[harga2] where buku_kas.id=$_POST[buku_kas_id2]");

    $up3 = mysqli_query($koneksi, "update biaya_lain set pilihan_biaya_id='" . $_POST['pilihan_biaya_id2'] . "', harga='" . $_POST['harga2'] . "',jumlah='" . $_POST['jumlah2'] . "', tanggal='" . $_POST['tanggal2'] . "', buku_kas_id=" . $_POST['buku_kas_id2'] . " where id=$_GET[id_ubah]");
  }
  if ($up and $up2 and $up3) {
    echo "<script type='text/javascript'>
		alert('Perubahan Berhasil Disimpan !');
		window.location='index.php?page=biaya_lain'
		</script>";
  } else {
    echo "<script type='text/javascript'>
		alert('Perubahan Gagal Disimpan !');
		window.location='index.php?page=biaya_lain'
		</script>";
  }
}
?>
<div id="openUbah" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Biaya Lain</h3>
    <form method="post">
      <label>No Akun</label>
      <select name="buku_kas_id2" class="form-control">
        <option>-- Pilih No Akun</option>
        <?php $query = mysqli_query($koneksi, "SELECT id,nama_akun FROM buku_kas");
        while ($row = mysqli_fetch_array($query)) {
        ?>
          <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $da['ide']) {
                                                      echo "selected";
                                                    } ?>><?php echo $row['nama_akun']; ?></option>
        <?php } ?>
      </select>
      <br />
      <label>Pembayaran</label>
      <select name="pilihan_biaya_id2" class="form-control">
        <option>-- Pilih Biaya --</option>
        <?php $query1 = mysqli_query($koneksi, "SELECT * FROM pilihan_biaya");
        while ($row1 = mysqli_fetch_array($query1)) {
        ?>
          <option value="<?php echo $row1['id'] ?>" <?php if ($row1['id'] == $da['id']) {
                                                      echo "selected";
                                                    } ?>><?php echo $row1['nama_biaya']; ?></option>
        <?php } ?>
      </select>
      <br />
      <label>Jumlah</label>
      <input name="jumlah2" class="form-control" type="number" placeholder="" value="<?php echo $da['jumlah']; ?>"><br />
      <label>Harga</label>
      <input name="harga2" class="form-control" type="number" placeholder="" value="<?php echo $da['harga']; ?>"><br />
      <label>Tanggal</label>
      <input name="tanggal2" class="form-control" type="date" placeholder="" value="<?php echo $da['tanggal']; ?>"><br />
      <button name="ubah_riwayat" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
    </form>


  </div>
</div>