<?php
if (isset($_POST['simpan_barang'])) {
  $_SESSION['tgl_masuk'] = $_POST['tgl_masuk'];
  $_SESSION['no_po'] = $_POST['no_po'];
  $_SESSION['stok_set'] = $_POST['stok_set'];
  mysqli_query($koneksi, "update barang_gudang set stok_total = $_POST[stok_set] where id=$_SESSION[id_barang]");
  echo "<script type='text/javascript'>		
  window.location='index.php?page=simpan_tambah_barang_set2';
		</script>
		";
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah Barang Set</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tambah Barang Set</li>
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
            <div class="box-body table-responsive no-padding">
              <div class="">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <form method="post" enctype="multipart/form-data">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom"><strong>Kategori Barang</strong></th>
                        <th valign="bottom"><strong>Nama Barang</strong></th>
                        <th valign="bottom">NIE</th>
                        <th valign="bottom"><strong>Tipe</strong></th>
                        <th valign="bottom">Merk</th>
                        <th valign="bottom"><strong>Negara Asal</strong></th>
                        <th valign="bottom"><strong>Deskripsi Alat</strong></th>
                      </tr>
                    </thead>
                    <?php

                    ?>
                    <tr>
                      <td><?php echo $_SESSION['kategori_brg']; ?>
                      <td><?php echo $_SESSION['nama_barang']; ?>
                      </td>
                      <td><?php echo $_SESSION['nie_brg']; ?></td>
                      <td><?php echo $_SESSION['tipe']; ?></td>
                      <td><?php echo $_SESSION['merk']; ?></td>
                      <td><?php echo $_SESSION['negara_asal']; ?></td>
                      <td><?php echo $_SESSION['deskripsi_alat']; ?></td>
                    </tr>
                  </table>
                  <br />
                  <table width="50%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="20%" valign="bottom">Tgl Masuk</th>
                        <th width="21%" valign="bottom">Nomor PO</th>
                        <th width="22%" valign="bottom">Stok (Set)</th>
                        <!-- <th width="37%" valign="bottom">Jumlah Jenis Barang Dalam 1 Set</th> -->
                      </tr>
                    </thead>
                    <?php

                    ?>
                    <tr>
                      <td><input id="" name="tgl_masuk" class="form-control" type="date" placeholder="" autofocus="autofocus" size="3" required /></td>
                      <td><input id="" name="no_po" class="form-control" type="text" placeholder="" size="4" required /></td>
                      <td><input name="stok_set" class="form-control" type="text" placeholder="" size="4" required="required" /></td>
                      <!-- <td><input name="stok_dalam_1set" class="form-control" type="text"  placeholder="" size="4" required="required"/></td> -->
                    </tr>
                  </table><br />
                  <center>
                    <button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Next</button>
                  </center>
                  <br />
                </form>
              </div>
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
<?php
if (isset($_POST['tambah_laporan'])) {
  $Result = mysqli_query($koneksi, "insert into aksesoris values('','" . $_POST['nama_akse'] . "','" . $_POST['merk'] . "','" . $_POST['tipe'] . "','" . $_POST['no_seri'] . "','" . $_POST['stok'] . "', '" . $_POST['deskripsi'] . "','" . $_POST['harga_satuan'] . "')");
  if ($Result) {
    echo "<script type='text/javascript'>
		alert('Data Berhasil Di Tambah !');
		window.location='index.php?page=simpan_tambah_aksesoris&id=$_GET[id]';
		</script>";
  }
}
?>
<div id="openAkse" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Tambah Aksesoris Baru</h3>
    <form method="post">
      <input name="nama_akse" class="form-control" type="text" required placeholder="Nama Aksesoris" autofocus><br />

      <input name="merk" class="form-control" type="text" placeholder="Merk" required><br />

      <input name="tipe" class="form-control" type="text" placeholder="Tipe" required><br />

      <input name="no" class="form-control" type="text" placeholder="Nomor Seri" required><br />

      <input name="stok" class="form-control" type="text" placeholder="Stok" required><br />

      <textarea name="deskripsi" class="form-control" type="text" rows="5" placeholder="Deskripsi Alat" required></textarea><br />
      <?php if (isset($_SESSION['user_administrator']) && isset($_SESSION['pass_administrator'])) { ?>
        <input name="harga_satuan" class="form-control" type="text" placeholder="Harga Satuan" required><br />
      <?php } ?>

      <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
      <br /><br />
    </form>

  </div>
</div>