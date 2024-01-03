<?php
// if (isset($_POST['simpan_akse'])) {
//   $s1 = mysqli_query($koneksi, "insert into barang_gudang_set values('', '" . $_SESSION['nama_akse'] . "', '" . $_SESSION['nie'] . "', '" . $_SESSION['tipe'] . "','" . $_SESSION['merk'] . "','" . $_SESSION['negara_asal'] . "','" . $_SESSION['deskripsi'] . "')");

//   $maks1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as maks from barang_gudang_set"));

//   $nilai_maks1 = $maks1['maks'];

//   $simpan_po = mysqli_query($koneksi, "insert into barang_gudang_po_set values('','$nilai_maks1','" . $_SESSION['tgl_masuk'] . "','" . $_SESSION['no_po'] . "','" . $_SESSION['stok_set'] . "')");

//   $maks = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as mak from barang_gudang_po_set"));

//   $nilai_maks = $maks['mak'];

//   for ($i = 0; $i < $_SESSION['stok_set']; $i++) {
//     $s2 = mysqli_query($koneksi, "insert into barang_gudang_set_1 values('','$nilai_maks')");
//     $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_set from barang_gudang_set_1"));
//     for ($j = 0; $j < $_SESSION['stok_dalam_1set']; $j++) {
//       $s3 = mysqli_query($koneksi, "insert into barang_gudang_set_2 values('','" . $max['id_set'] . "','" . $_POST['nama_brg'][$j] . "','" . $_POST['harga_beli'][$j] . "','" . $_POST['harga_jual'][$j] . "','" . $_POST['qty'][$j] . "')");
//     }
//     //$sum = mysqli_fetch_array(mysqli_query($koneksi, "select sum(harga_jual*qty)"));
//   }

//   if ($s1 and $s2 and $s3 and $simpan_po) {
//     echo "<script type='text/javascript'>
// 		alert('Data Berhasil Disimpan !');		window.location='index.php?page=barang_set';
// 		</script>
// 		";
//     unset($_SESSION['tgl_masuk']);
//     unset($_SESSION['no_po']);
//     unset($_SESSION['nama_akse']);
//     unset($_SESSION['nie']);
//     unset($_SESSION['tipe']);
//     unset($_SESSION['merk']);
//     unset($_SESSION['negara_asal']);
//     unset($_SESSION['stok_set']);
//     unset($_SESSION['stok_dalam_1set']);
//     unset($_SESSION['deskripsi']);
//     unset($_SESSION['harga_beli']);
//     unset($_SESSION['harga_jual']);
//   }
// }

if (isset($_POST['pencarian'])) {
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail_set where barang_gudang_id = " . $_POST['nama_barang'] . " and barang_gudang_set_id = " . $_SESSION['id_barang'] . ""));
  if ($cek == 0) {
    $Result = mysqli_query($koneksi, "insert into barang_gudang_detail_set values('','" . $_SESSION['id_barang'] . "','" . $_POST['nama_barang'] . "', '" . $_POST['qty'] . "')");
  } else {
    echo "<script>alert('Barang Sudah Dimasukkan !')</script>";
  }
}

if (isset($_GET['id_hapus'])) {
  $del = mysqli_query($koneksi, "delete from barang_gudang_detail_set where id=" . $_GET['id_hapus'] . "");
  if ($del) {
    echo "<script type='text/javascript'>
      alert('Berhasil di hapus !');
		</script>";
  }
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
                        <th valign="bottom">Tgl Masuk</th>
                        <th valign="bottom">Po Nomor</th>
                        <th valign="bottom"><strong>Kategori Barang</strong></th>
                        <th valign="bottom"><strong>Nama Barang</strong></th>
                        <th valign="bottom">NIE</th>
                        <th valign="bottom"><strong>Tipe</strong></th>
                        <th valign="bottom">Merk</th>
                        <th valign="bottom"><strong>Negara Asal</strong></th>
                        <th valign="bottom"><strong>Deskripsi Alat</strong></th>
                        <th valign="bottom">Stok (Set)</th>
                      </tr>
                    </thead>
                    <?php

                    ?>
                    <tr>
                      <td><?php echo date("d/m/Y", strtotime($_SESSION['tgl_masuk'])); ?></td>
                      <td><?php echo $_SESSION['no_po']; ?></td>
                      <td><?php echo $_SESSION['kategori_brg']; ?>
                      <td><?php echo $_SESSION['nama_akse']; ?>
                      </td>
                      <td><?php echo $_SESSION['nie']; ?></td>
                      <td><?php echo $_SESSION['tipe']; ?></td>
                      <td><?php echo $_SESSION['merk']; ?></td>
                      <td><?php echo $_SESSION['negara_asal']; ?></td>
                      <td><?php echo $_SESSION['deskripsi']; ?></td>
                      <td bgcolor=""><?php echo $_SESSION['stok_set']; ?></td>
                    </tr>
                  </table><br />
                  <br />
                  <div style="margin-bottom: 10px;"><button name="tambah_detail" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-pencarian"><i class="fa fa-plus"></i> Tambah Rincian Barang</button></div>
                  <div class="table-responsive">
                    <table width="100%" id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th width="">No</th>
                          <th width=""><strong>Nama Barang</strong></th>
                          <th width="">Harga Beli</th>
                          <th width="">Harga Jual</th>
                          <th width="">Qty</th>
                          <th width=""><strong>Aksi</strong></th>
                        </tr>
                      </thead>
                      <?php
                      $q2 = mysqli_query($koneksi, "select *,barang_gudang_detail_set.id as idd from barang_gudang_detail_set, barang_gudang where barang_gudang.id=barang_gudang_detail_set.barang_gudang_id and barang_gudang_set_id=" . $_SESSION['id_barang'] . " order by nama_brg ASC");
                      $no = 0;
                      while ($d = mysqli_fetch_array($q2)) {
                        $no++;
                      ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $d['nama_brg']; ?></td>
                          <td><?php echo number_format($d['harga_beli'], 0, '.', ','); ?></td>
                          <td><?php echo number_format($d['harga_satuan'], 0, '.', ','); ?></td>
                          <td><?php echo $d['qty']; ?></td>

                          <td>
                            <a href="index.php?page=simpan_tambah_barang_set2&id_hapus=<?php echo $d['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span></a>&nbsp;
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                  </div>
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

<div class="modal fade" id="modal-pencarian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Rincian Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <label>Nama Barang</label>
          <select class="form-control select2" name="nama_barang" required style="width:100%">
            <option value="">...</option>
            <?php
            $q_b = mysqli_query($koneksi, "select id,nama_brg,tipe_brg,merk_brg from barang_gudang order by nama_brg ASC");
            while ($d = mysqli_fetch_array($q_b)) {
            ?>
              <option value="<?php echo $d['id'] ?>"><?php echo "<strong>" . $d['nama_brg'] . "</strong> - " . $d['tipe_brg'] . "/" . $d['merk_brg']; ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label>Qty</label>
          <input type="number" class="form-control" name="qty" placeholder="" required="required" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Tambahkan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>