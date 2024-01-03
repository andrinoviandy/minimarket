<?php
if (isset($_GET['id_hapus'])) {
  $hapus2 = mysqli_query($koneksi, "delete from aksesoris_jual_detail where aksesoris_jual_id=" . $_GET['id_hapus'] . "");
  //$hapus1 = mysqli_query($koneksi, "delete from aksesoris_jual where aksesoris_id=".$_GET['id_hapus']."");
  $hapus = mysqli_query($koneksi, "delete from aksesoris_jual where id=" . $_GET['id_hapus'] . "");
  if ($hapus and $hapus2) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Dihapus ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(()=> {
      window.location.href = '?page=$_GET[page]';
    })
    </script>";
  } else {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Data Tidak Dapat Dihapus ',
      icon: 'error',
      confirmButtonText: 'OK',
    }).then(()=> {
      window.location.href = '?page=$_GET[page]';
    })
    </script>";
  }
}

if (isset($_POST['kirim_barang'])) {
  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_pengiriman'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['no_po'] = $_POST['no_po'];
  echo "<script type='text/javascript'>
		window.location='index.php?page=pilih_no_seri_akse&id=" . $_POST['idd'] . "';
		</script>";
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Pengiriman Aksesoris</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pengiriman Aksesoris</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12">
        <div class="box box-body">
          <?php if (isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_administrator'])) { ?>
            <a href="index.php?page=jual_akse">
              <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Jual</button></a>

          <?php } ?>
          <div class="pull pull-right">
            <?php include "include/getFilter.php";
            ?>
            <?php include "include/atur_halaman.php"; ?>
          </div>
        </div>

      </section>
      <?php include "include/header_pencarian.php"; ?>

      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
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

<!--kirim akssoris-->
<?php

if (isset($_POST['kirim2_barang'])) {
  if ($_POST['id_alkes'] == 'all') {
    $update = mysqli_query($koneksi, "insert into barang_dikirim values('','" . $_POST['nama_paket'] . "','" . $_POST['no_peng'] . "','" . $_POST['tgl_kirim'] . "','" . $_POST['no_po'] . "','0000-00-00')");
    $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_kirim from barang_dikirim"));
    $sel = mysqli_query($koneksi, "select * from barang_dijual_detail where barang_dijual_id=" . $_GET['id'] . "");
    $tot_sel = mysqli_num_rows($sel);
    while ($data_sel = mysqli_fetch_array($sel)) {
      $ins = mysqli_query($koneksi, "insert into barang_dikirim_detail values('','" . $max['id_kirim'] . "','" . $data_sel['id'] . "')");
    }

    if ($update and $ins) {
      mysqli_query($koneksi, "update barang_dijual_detail set status_kirim=1 where barang_dijual_id=" . $_GET['id'] . "");

      echo "<script type='text/javascript'>
		alert('Data Berhasil Di Simpan !');
		window.location='index.php?page=kirim_barang&id_krm=" . $_GET['id'] . "';
		</script>";
    } else {
      echo "<script type='text/javascript'>
		alert('Gagal Disimpan');
		</script>";
    }
  } else {
    $update = mysqli_query($koneksi, "insert into barang_dikirim values('','" . $_POST['nama_paket'] . "','" . $_POST['no_peng'] . "','" . $_POST['tgl_kirim'] . "','" . $_POST['no_po'] . "','0000-00-00')");
    $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_kirim from barang_dikirim"));
    $ins = mysqli_query($koneksi, "insert into barang_dikirim_detail values('','" . $max['id_kirim'] . "','" . $_POST['id_alkes'] . "')");
    if ($update and $ins) {
      mysqli_query($koneksi, "update barang_dijual_detail set status_kirim=1 where id=" . $_POST['id_alkes'] . "");
      echo "<script type='text/javascript'>
		alert('Data Berhasil Di Simpan !');
		window.location='index.php?page=kirim_barang&id_krm=" . $_GET['id'] . "';
		</script>";
    } else {
      echo "<script type='text/javascript'>
		alert('Gagal Disimpan');
		</script>";
    }
  }
}
?>
<div id="openKirim" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Kirim Aksesoris</h3>
    <form method="post">
      <!--<label>Pilih Aksesoris</label>
     <select id="input" name="id_alkes" required>
     	<?php
        $q3 = mysqli_query($koneksi, "select *,aksesoris_jual_detail.id as idd from aksesoris_jual_detail,aksesoris,aksesoris_detail where aksesoris_detail.id=aksesoris_jual_detail.aksesoris_detail_id and aksesoris.id=aksesoris_detail.aksesoris_id and status_kirim_akse=0 and aksesoris_jual_id=" . $_GET['id'] . "");
        $q4 = mysqli_query($koneksi, "select *,aksesoris_jual_detail.id as idd from aksesoris_jual_detail,aksesoris,aksesoris_detail where aksesoris_detail.id=aksesoris_jual_detail.aksesoris_detail_id and aksesoris.id=aksesoris_detail.aksesoris_id and status_kirim_akse=1 and aksesoris_jual_id=" . $_GET['id'] . "");
        $d4 = mysqli_num_rows($q4);
        if ($d4 == 0) {
        ?>
        <option value="all">All</option>
        <?php } ?>
        <?php
        while ($d3 = mysqli_fetch_array($q3)) { ?>
		<option value="<?php echo $d3['idd']; ?>"><?php echo $d3['nama_akse'] . " - No Seri : " . $d3['no_seri_akse']; ?></option>
		<?php } ?>
     </select>-->
      <label>Nama Paket</label>
      <input id="input" type="text" placeholder="" name="nama_paket" required>
      <label>No. Pengiriman</label>
      <input id="input" type="text" placeholder="" name="no_pengiriman" required>
      <label>Tanggal Pengiriman</label>
      <input id="input" type="date" placeholder="" name="tgl_kirim" required>
      <label>No. PO</label>
      <input id="input" type="text" placeholder="" name="no_po" value="<?php
                                                                        $d5 = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_jual_akse from aksesoris_jual where id=" . $_GET['id'] . ""));
                                                                        echo $d5['no_po_jual_akse'];
                                                                        ?>" readonly="readonly">

      <button id="buttonn" name="kirim_barang" type="submit">Next</button>
    </form>
  </div>
</div>
<div class="modal fade" id="modal-kirim">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Kirim Aksesoris</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <input type="hidden" name="idd" id="idd" />
          <label>Nama Paket</label>
          <input id="input" type="text" placeholder="" name="nama_paket" required>
          <label>No. Pengiriman</label>
          <input id="input" type="text" placeholder="" name="no_pengiriman" required>
          <label>Tanggal Pengiriman</label>
          <input id="input" type="date" placeholder="" name="tgl_kirim" required>
          <label>No. PO</label>
          <input type="text" class="form-control" name="no_po" id="no_po" readonly="readonly">


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="kirim_barang" type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function modalKirim(id, no_po) {
    document.getElementById("idd").value = id
    document.getElementById("no_po").value = no_po
    $('#modal-kirim').modal('show')
  }
</script>