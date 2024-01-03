<?php
if (isset($_GET['id_hapus'])) {
  $hapus2 = mysqli_query($koneksi, "delete from barang_gudang_set_2,barang_gudang_set_1,barang_gudang_set,barang_gudang_po_set where barang_gudang_set.id=barang_gudang_po_set.barang_gudang_set_id and barang_gudang_po_set.id=barang_gudang_set_1.barang_gudang_po_set_id and barang_gudang_set_1.id=barang_gudang_set_2.barang_gudang_set1_id and barang_gudang_set.id=" . $_GET['id_hapus'] . "");
  if ($hapus2) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Dihapus ',
      icon: 'success',
      confirmButtonText: 'OK',
    })
    </script>";
  } else {
    echo "<script>
		Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Data Gagal Dihapus',
      text : 'Kemungkinan Data Sedang Digunakan',
      icon: 'error',
      confirmButtonText: 'OK',
    })
		</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Data Barang Set</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Data Barang Set</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <section class="col-lg-12">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-default">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
                  <a href="index.php?page=tambah_barang_set">
                    <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Alkes</button></a>
                </div>
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <div class="">
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
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List -->
        <!-- /.box -->

        <!-- quick email widget -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">

        <!-- Map box -->
        <!-- /.box -->

        <!-- solid sales graph -->
        <!-- /.box -->

        <!-- Calendar -->
        <!-- /.box -->

      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<?php
if (isset($_POST['jual'])) {
  $jml1 = mysqli_fetch_array(mysqli_query($koneksi, "select * from master_barang where id=" . $_GET['id'] . ""));
  if ($_POST['qty'] <= $jml1['stok']) {
    $q = mysqli_query($koneksi, "insert into jual_barang values('','" . $_GET['id'] . "','" . $_POST['pembeli'] . "','" . $_POST['alamat'] . "','" . $_POST['qty'] . "','" . $_POST['tgl_beli'] . "','','','','','','','','','','','')");
    if ($q) {
      mysqli_query($koneksi, "update master_barang set stok=stok-" . $_POST['qty'] . " where id=" . $_GET['id'] . "");
      echo "<script type='text/javascript'>
		  window.location='index.php?page=jual_barang&id_lihat_jual=" . $_GET['id'] . "';
		  </script>";
    }
    //$d = mysqli_fetch_array(mysqli_query($koneksi, "select * from master barang where id=".$_GET['id'].""));
  } else {
    echo "<script type='text/javascript'>
		  alert('Data Stok Kurang !');
		  </script>";
  }
}
?>
<div id="openQuantity" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Jual Alkes</h3>
    <form method="post">
      Tgl Dijual
      <input id="input" type="date" placeholder="" name="tgl_beli" required>
      Pembeli
      <input id="input" type="text" placeholder="Pembeli (RS/Dinas/Puskesmas/Klinik" name="pembeli" required>
      Provinsi
      <select id="input">
        <option>-- Pilih --</option>
        <?php $q1 = mysqli_query($koneksi, "select * from alamat_provinsi order by nama_provinsi ASC");
        while ($row1 = mysqli_fetch_array($q1)) {
        ?>
          <option value="<?php echo $row1['id']; ?>"><?php echo $row1['nama_provinsi']; ?></option>
        <?php } ?>
      </select>
      Kabupaten
      <select id="input">
        <option>-- Pilih --</option>
        <?php $q2 = mysqli_query($koneksi, "select * from alamat_kabupaten order by nama_kabupaten ASC");
        while ($row2 = mysqli_fetch_array($q2)) {
        ?>
          <option value="<?php echo $row2['id']; ?>"><?php echo $row2['nama_kabupaten']; ?></option>
        <?php } ?>
      </select>
      Kecamatan
      <select id="input">
        <option>-- Pilih --</option>
        <?php $q3 = mysqli_query($koneksi, "select * from alamat_kecamatan order by nama_kecamatan ASC");
        while ($row3 = mysqli_fetch_array($q3)) {
        ?>
          <option value="<?php echo $row3['id']; ?>"><?php echo $row3['nama_kecamatan']; ?></option>
        <?php } ?>
      </select>
      Alamat Jalan
      <input id="input" type="text" placeholder="Jl.Xxx" name="alamat" required>
      Quantity
      <input id="input" type="text" placeholder="Quantity" name="qty" required>
      <button id="buttonn" name="jual" type="submit">Jual Alkes</button>
    </form>
  </div>
</div>

<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=aksesoris_jual&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=aksesoris_jual2&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
  </div>
</div>

<script>
  function hapus(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Barang Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id;
      }
    })
  }
</script>