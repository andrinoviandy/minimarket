<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id=" . $_GET['id'] . ""));

if (isset($_POST['simpan_barang'])) {
  if ($data['kategori_brg'] == 'Set') {
    $nilai_maks = $_GET['id'];
    $update_stok = mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total+" . $_POST['stok'] . " where id=$nilai_maks");

    $simpan_po = mysqli_query($koneksi, "insert into barang_gudang_po values('','$nilai_maks','" . $_POST['tgl_masuk'] . "','" . $_POST['no_po'] . "','" . $_POST['stok'] . "')");

    $max_po = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as max_po from barang_gudang_po"));

    $set = mysqli_query($koneksi, "select * from barang_gudang_detail_set where barang_gudang_set_id = $nilai_maks");

    while ($dt = mysqli_fetch_array($set)) {
      for ($j = 0; $j < ($_POST['stok'] * $dt['qty']); $j++) {
        $s = mysqli_query($koneksi, "insert into barang_gudang_detail values('','$dt[barang_gudang_id]','" . $max_po['max_po'] . "','','','','','','0','0','0','0')");
      }
      mysqli_query($koneksi, "insert into barang_pesan_detail_set values('','$_GET[id_detail]','" . $dt['barang_gudang_id'] . "','" . $dt['qty'] . "')");
      mysqli_query($koneksi, "update barang_gudang set stok_total=stok_total+" . ($_POST['stok'] * $dt['qty']) . " where id=$dt[barang_gudang_id]");
    }

    $d = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pesan_detail where id=" . $_GET['id_detail'] . ""));
    $cek = mysqli_fetch_array(mysqli_query($koneksi, "select sum(stok) as stok_sudah from barang_gudang_po where no_po_gudang='" . $_POST['no_po'] . "' and barang_gudang_id=" . $_GET['id'] . ""));
    if ($d['qty'] - $cek['stok_sudah'] <= 0) {
      mysqli_query($koneksi, "update barang_pesan_detail set status_ke_stok=1 where id=" . $_GET['id_detail'] . "");
    }
    if ($update_stok && $simpan_po && $s) {
      echo "<script type='text/javascript'>
            addRiwayat('INSERT', 'barang_pesan&barang_gudang', '$nilai_maks', 'Mutasi Stok Sejumlah $_POST[stok]')
            alert('Data Alkes Berhasil Dimutasi !');		window.location='index.php?page=mutasi&id=$_GET[id_pesan]';
            </script>
            ";
    } else {
      echo "<script type='text/javascript'>
            alert('Gagal Mutasi !');
            </script>
            ";
    }
  } else {
    if ($_POST['stok'] <= $_GET['stok']) {
      echo "<script type='text/javascript'>		window.location='index.php?page=simpan_tambah_ke_stok2&id=$_GET[id]&id_pesan=$_GET[id_pesan]&id_detail=$_GET[id_detail]';
      </script>
      ";
      $_SESSION['tgl_masuk'] = $_POST['tgl_masuk'];
      $_SESSION['no_po'] = $_POST['no_po'];
      $_SESSION['stok'] = $_POST['stok'];
      $_SESSION['tgl_expired'] = $_POST['tgl_expired'];
    } else {
      echo "<script type='text/javascript'>
      alert('Maaf, Maksimal stok yang dimutasi adalah $_GET[stok]');
      history.back();
      </script>";
    }
  }
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah Detail Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tambah Detail Alkes</li>
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
                        <th valign="bottom"><strong>Kategori</strong></th>
                        <th valign="bottom"><strong>Nama Alkes</strong></th>
                        <th valign="bottom">NIE</th>
                        <th valign="bottom"><strong>Tipe</strong></th>
                        <th valign="bottom">Merk</th>
                        <th valign="bottom"><strong>Negara Asal</strong></th>
                        <th valign="bottom"><strong>Deskripsi Alat</strong></th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php echo $data['kategori_brg']; ?></td>
                      <td><?php echo $data['nama_brg']; ?></td>
                      <td><?php echo $data['nie_brg']; ?></td>
                      <td><?php echo $data['tipe_brg']; ?></td>
                      <td><?php echo $data['merk_brg']; ?></td>
                      <td><?php echo $data['negara_asal']; ?></td>
                      <td><?php echo $data['deskripsi_alat']; ?></td>
                    </tr>
                  </table>
                  <br />
                  <table width="50%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom">Tgl Masuk</th>
                        <th valign="bottom">Nomor PO</th>
                        <th valign="bottom">Tgl Expired</th>
                        <th valign="bottom">Stok</th>
                      </tr>
                    </thead>
                    <?php

                    ?>
                    <tr>
                      <td><input id="" name="tgl_masuk" class="form-control" type="date" placeholder="" autofocus="autofocus" size="3" required /></td>
                      <td>
                        <?php
                        $data2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pesan where id=" . $_GET['id_pesan'] . ""));
                        ?>
                        <input id="" name="no_po" class="form-control" type="text" placeholder="" size="4" required value="<?php echo $data2['no_po_pesan']; ?>" readonly="readonly" />
                      </td>
                      <td><input id="" name="tgl_expired" class="form-control" type="date" placeholder="" size="3" /></td>
                      <td><input id="no_po" name="stok" class="form-control" type="text" placeholder="" size="1" required="required" value="<?php echo $_GET['stok']; ?>" /></td>
                    </tr>
                  </table><br />
                  <center>
                    <button name="simpan_barang" onclick="return confirm('Jika Kategori Set , Maka Akan Langsung Tersimpan\nJika Bukan , Maka Akan Input No Seri')" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Next</button>
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