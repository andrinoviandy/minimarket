<?php
if (isset($_POST['buat_training'])) {
  $nama_lamp1 = ($_FILES["lamp1"]["name"]);
  $fisik_lamp1 = ($_FILES["lamp1"]["tmp_name"]);
  $nama_lamp2 = ($_FILES["lamp2"]["name"]);
  $fisik_lamp2 = ($_FILES["lamp2"]["tmp_name"]);
  $queri = mysqli_query($koneksi, "INSERT INTO pelatihan_alat values('','" . $_GET['id'] . "','" . $_POST['peserta'] . "','" . $_POST['pelatih'] . "','" . $_POST['tgl_pelatihan'] . "','" . $nama_lamp1 . "','" . $nama_lamp2 . "')");

  if ($queri) {
    copy($fisik_lamp1, "gambar_pelatihan/" . $nama_lamp1);
    copy($fisik_lamp2, "gambar_pelatihan/" . $nama_lamp2);
    echo "<script type='text/javascript'>
	window.location='index.php?page=uji_fungsi_instalasi';
		  </script>";
  } else {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Data Gagal Disimpan',
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
    <h1>
      Instalasi & Uji Fungsi</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Uji Fungsi &amp; Instalasi</li>
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
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-default">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <div class="pull pull-left">
                  <button class="btn btn-info" data-toggle="modal" data-target="#modal-cetak"><span class="fa fa-print"></span> Rekap</button>
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
        <!-- /.box (chat box) -->

        <!-- TO DO List -->
        <!-- /.box -->

        <!-- quick email widget -->
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
  $q = mysqli_query($koneksi, "update jual_barang set status_f=" . $_POST['status_f'] . ", status_i=" . $_POST['status_i'] . ", tgl_uji_fungsi='" . $_POST['tgl_uji_fungsi'] . "', tgl_instalasi='" . $_POST['tgl_instalasi'] . "', lampiran='" . $_FILES['lampiran']['name'] . "' where id=" . $_GET['id'] . "");
  if ($q) {
    copy($_FILES['lampiran']['tmp_name'], "gambar_fi/" . $_FILES['lampiran']['name']);
    echo "<script type='text/javascript'>
		  window.location='index.php?page=uji_fungsi_instalasi';
		  </script>";
  }
  //$d = mysqli_fetch_array(mysqli_query($koneksi, "select * from master barang where id=".$_GET['id'].""));
}

if (isset($_POST['buat_spk'])) {
  $q2 = mysqli_query($koneksi, "update jual_barang set id_teknisi=" . $_POST['teknisi'] . ", tgl_spk_instalasi='" . $_POST['tgl_spk_instalasi'] . "' where id=$_GET[id]");
  if ($q2) {
    echo "<script type='text/javascript'>
	window.location='index.php?page=uji_fungsi_instalasi';
		  </script>";
  }
}


?>
<div id="openUbahStatus" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Status Uji Fungsi &amp; Instalasi</h3>
    <?php
    $data_status = mysqli_fetch_array(mysqli_query($koneksi, "select * from jual_barang where id=$_GET[id]"));
    ?>
    <form method="post" enctype="multipart/form-data">
      <label id="">Tgl Uji Fungsi</label>
      <input name="tgl_uji_fungsi" type="date" id="input" value="<?php echo $data_status['tgl_uji_fungsi']; ?>" required />
      <?php if ($data_status['status_f'] != 0) { ?>
        <label>Status Uji Fungsi</label>
        <select name="status_f" id="input">
          <option value="1">OK</option>
          <option value="0">TIDAK</option>
        </select>
      <?php } else { ?>
        <label>Status Uji Fungsi</label>
        <select name="status_f" id="input">
          <option value="0">TIDAK</option>
          <option value="1">OK</option>
        </select>
      <?php }  ?>
      <label id="">Tgl Instalasi</label>
      <input name="tgl_instalasi" type="date" id="input" value="<?php echo $data_status['tgl_instalasi']; ?>" required />
      <?php if ($data_status['status_i'] != 0) { ?>
        <label>Status Instalasi</label>
        <select name="status_i" id="input">
          <option value="1">OK</option>
          <option value="0">TIDAK</option>
        </select>
      <?php } else { ?>
        <label>Status Instalasi</label>
        <select name="status_i" id="input">
          <option value="0">TIDAK</option>
          <option value="1">OK</option>
        </select>
      <?php }  ?>
      <label>Lampiran</label>
      <input name="lampiran" type="file" style="background-color:#FFF" id="input" />
      <button id="buttonn" name="jual" type="submit">Simpan</button>
    </form>
  </div>
</div>

<div id="openBuatSPK" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Pembuatan SPK Instalasi</h3>
    <?php
    $data_spk = mysqli_fetch_array(mysqli_query($koneksi, "select * from jual_barang where id=$_GET[id]"));
    ?>
    <form method="post">
      <label>Tgl SPK</label>
      <input name="tgl_spk_instalasi" type="date" id="input" value="<?php echo $data_spk['tgl_spk_instalasi']; ?>" />
      <label>Teknisi</label>
      <select name="teknisi" id="input">
        <option>--Pilih Teknisi--</option>
        <?php
        $q_tek = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
        while ($d_t = mysqli_fetch_array($q_tek)) {
        ?>
          <option value="<?php echo $d_t['id']; ?>"><?php echo $d_t['nama_teknisi']; ?></option>
        <?php } ?>
      </select>
      <button id="buttonn" name="buat_spk" type="submit">Simpan</button>
    </form>
  </div>
</div>

<div id="openPelatihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Pelatihan Alkes</h3>
    <?php
    $data_spk = mysqli_fetch_array(mysqli_query($koneksi, "select * from jual_barang where id=$_GET[id]"));
    ?>
    <form method="post" enctype="multipart/form-data">
      <label>Tgl Pelatihan</label>
      <input name="tgl_pelatihan" type="date" id="input" />
      <input id="input" name="peserta" type="text" placeholder="Peserta" />
      <input id="input" name="pelatih" type="text" placeholder="Pelatih" />
      <!--<select name="pelatih" id="input">
     <option>--Pilih Pelatih--</option>
     <?php
      //$q_tek = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
      //while ($d_t = mysqli_fetch_array($q_tek)) {
      ?>
     <option value="<?php //echo $d_t['id']; 
                    ?>"><?php //echo $d_t['nama_teknisi']; 
                        ?></option>
     <?php //} 
      ?>
     </select>-->
      <input name="lamp1" type="file" id="input" style="background-color:#FFF" />
      <input name="lamp2" type="file" id="input" style="background-color:#FFF" />
      <button id="buttonn" name="buat_training" type="submit">Simpan</button>
    </form>
  </div>
</div>

<div id="detailAkse" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Detail Aksesoris</h3>
    Nama Aksesoris
    <input id="input" disabled="disabled" value="<?php echo $q3['nama_brg']; ?>" />
    Merk
    <input id="input" disabled="disabled" value="<?php echo $q3['merk_brg']; ?>" />
    Tipe
    <input id="input" disabled="disabled" value="<?php echo $q3['tipe_brg']; ?>" />
    NIE
    <input id="input" disabled="disabled" value="<?php echo $q3['nie_brg']; ?>" />
    Deksripsi Alkes
    <input id="input" disabled="disabled" value="<?php echo $q3['deskripsi_alat']; ?>" /><br /><br />
  </div>
</div>

<div class="modal fade" id="modal-cetak">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <center>
            Rekap Instalasi & Uji Fungsi
          </center>
        </h4>
      </div>
      <form method="post" enctype="multipart/form-data" action="cetak_laporan_rekapan_instalasi.php">
        <div class="modal-body">
          <label>Dari Tanggal</label>
          <input name="tgl1" type="date" class="form-control" placeholder="" value=""><br />
          <label>Sampai Tanggal</label>
          <input name="tgl2" type="date" class="form-control" placeholder="" value=""><br />
          <!--<label>Status Barang</label>
              <select class="form-control" style="width:100%" name="status">
              <option value="Semua">Semua</option>
              <option value="Sudah Terkirim">Sudah Terkirim</option>
              </select>
              -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" name="cetak">Cetak</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>