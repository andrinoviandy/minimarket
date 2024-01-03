<?php
if (isset($_POST['ubah_deskripsi'])) {
  $s = mysqli_query($koneksi, "update barang_teknisi set keterangan_spk='" . str_replace("\r\n", "<br>", $_POST['keterangan_spk']) . "' where id=" . $_POST['id_spk'] . "");
  if ($s) {
    echo "<script>window.location='index.php?page=spk_masuk'</script>";
  }
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php if (isset($_SESSION['id_b'])) {
        echo "Alkes Yang Akan Diinstal";
      } else { ?>
        SPI Masuk
      <?php } ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">SPI Masuk</li>
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
                <span class="pull pull-left">
                  <table>
                    <tr>
                      <td valign="top"><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                        barang telah dikembalikan karena mengalami kerusakan</td>
                    </tr>
                  </table>
                </span>
                <div class="pull pull-right">
                  <?php include "include/getFilter.php";
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
      <input id="input" type="date" placeholder="" name="tgl_beli" required>
      <input id="input" type="text" placeholder="Pembeli (RS/Dinas/Puskesmas/Klinik" name="pembeli" required>
      <input id="input" type="text" placeholder="Alamat" name="alamat" required>
      <input id="input" type="text" placeholder="Quantity" name="qty" required>
      <button id="buttonn" name="jual" type="submit">Jual Alkes</button>
    </form>
  </div>
</div>

<?php
$d_t = mysqli_fetch_array(mysqli_query($koneksi, "select * from tb_teknisi where id=$_GET[id_tek]"));
?>
<div id="open_teknisi" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Detail Teknisi</h3>
    <form method="post">
      <strong>Nama</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['nama_teknisi']; ?>" />
      <strong>Kompetensi</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['bidang']; ?>" />
      <strong>No HP</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['no_hp']; ?>" />
      <strong>No STR</strong>
      <input id="input" type="text" readonly="readonly" value="<?php echo $d_t['no_str']; ?>" />
      <table width="100%">
        <tr>
          <td align="center"><strong>Ijazah</strong></td>
          <td align="center"><strong>Sertifikat</strong></td>
        </tr>
        <tr>
          <td align="center"><a href="ijazah_teknisi/<?php echo $d_t['ijazah']; ?>" target="_blank"><img src="ijazah_teknisi/<?php echo $d_t['ijazah']; ?>" width="50px" /></a></td>
          <td align="center"><a href="ijazah_teknisi/sertifikat/<?php echo $d_t['sertifikat']; ?>" target="_blank"><img src="ijazah_teknisi/sertifikat/<?php echo $d_t['sertifikat']; ?>" width="50px" /></a></td>
        </tr>
      </table>

    </form>
  </div>
</div>

<div id="openUji" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Uji Fungsi & Instalasi</h3>
    <form method="post">
      <input name="nama_teknisi" id="input" type="text" required placeholder="Nama Teknisi"><br />

      <input name="bidang" id="input" type="text" placeholder="Bidang" required><br />
      <input name="no_str" id="input" placeholder="No STR" required><br />
      <input name="no_hp" id="input" type="text" placeholder="No HP" required><br />
      <input name="username" id="input" type="text" placeholder="Username" required><br />
      <input name="password" id="input" type="password" placeholder="Password" required><br />
      Ijazah
      <input name="ijazah" style="background-color:#FFF" id="input" type="file" /><br />
      Sertifikat
      <input name="sertifikat" id="input" type="file" style="background-color:#FFF" /><br />
      <button id="buttonn" name="tambahteknisibaru" type="submit">Jual Alkes</button>
    </form>
  </div>
</div>

<?php
$d_tek = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_teknisi where id=$_GET[id]"));
if (isset($_POST['simpan_teknisi'])) {
  $sim = mysqli_query($koneksi, "update barang_teknisi set teknisi_id='" . $_POST['id_teknisi'] . "', estimasi='" . $_POST['estimasi'] . "', tgl_berangkat_teknisi='" . $_POST['tgl_berangkat'] . "' where id=$_GET[id]");
  if ($sim) {
    echo "<script>window.location='index.php?page=spk_masuk'</script>";
  }
}

?>
<div id="openTeknisi" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center"></h3>
    <form method="post">
      <label>Teknisi</label>
      <select name="id_teknisi" class="form-control" <?php echo $dis; ?>>
        <option value="">--Pilih Teknisi--</option>
        <?php
        $query_teknisi = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
        while ($data_t = mysqli_fetch_array($query_teknisi)) {
        ?>
          <option <?php if ($d_tek['teknisi_id'] == $data_t['id']) {
                    echo "selected";
                  } ?> value="<?php echo $data_t['id']; ?>"><?php echo $data_t['nama_teknisi'] . " - " . $data_t['bidang']; ?></option>
        <?php } ?>
      </select><br />
      <label>Estimasi</label>
      <input id="input" type="date" placeholder="" value="<?php echo $d_tek['estimasi']; ?>" name="estimasi"><br /><br />
      <label>Tgl Berangkat</label>
      <input id="input" type="date" placeholder="" name="tgl_berangkat" value="<?php echo $d_tek['tgl_berangkat_teknisi']; ?>">
      <button id="buttonn" name="simpan_teknisi" type="submit">Simpan</button>
    </form>
  </div>
</div>

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Deskripsi</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <p align="justify">
            <input type="hidden" id="id_spk" name="id_spk" />
            <label>Deskripsi</label>
            <textarea rows="4" class="form-control" id="keterangan_spk" name="keterangan_spk">
            </textarea>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button class="btn btn-success" name="ubah_deskripsi" type="submit">Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function modalDeskripsi(id, deskripsi) {
    document.getElementById("id_spk").value = id
    document.getElementById("keterangan_spk").innerHTML = deskripsi.replace("<br>", "\n")
    $('#modal-ubah').modal('show');
  }
</script>