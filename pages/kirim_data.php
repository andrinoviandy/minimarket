<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select id, no_po_jual from barang_dijual where id= $_GET[id]"));

if (isset($_POST['kirim_barang'])) {
  mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id=" . $_SESSION['id'] . "");

  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_peng'];
  $_SESSION['ekspedisi'] = $_POST['ekspedisi'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['via_pengiriman'] = $_POST['via_kirim'];
  $_SESSION['estimasi'] = $_POST['estimasi_brg_sampai'];
  $_SESSION['biaya_kirim'] = str_replace(".", "", $_POST['biaya_kirim']);
  $_SESSION['no_po'] = $_POST['no_po'];

  echo "<script type='text/javascript'>
		window.location='index.php?page=pilih_no_seri&id=" . $_POST['id_kirim'] . "';
		</script>";
}



?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Kirim Alkes
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kirim Alkes</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">

      <?php include "include/header_pencarian.php"; ?>
      <!-- Left col -->
      <section class="col-lg-6 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">

              <form method="post">
                <div class="modal-body">
                  <input type="hidden" name="id_kirim" value="<?php echo $data['id']; ?>" />
                  <label>No. PO</label>
                  <input type="text" class="form-control" placeholder="" readonly="readonly" name="no_po" value="<?php
                                                                                                        echo $data['no_po_jual'];
                                                                                                        ?>">
                  <br>
                  <label>Nama Paket</label>
                  <input type="text" class="form-control" placeholder="" name="nama_paket" required autofocus="autofocus">
                  <br>
                  <label>No. Surat Jalan</label>
                  <input type="text" class="form-control" placeholder="" name="no_peng" required>
                  <br>
                  <label>Ekspedisi</label>
                  <input type="text" class="form-control" placeholder="" name="ekspedisi" required>
                  <br>
                  <label>Tanggal Pengiriman</label>
                  <input type="date" class="form-control" placeholder="" name="tgl_kirim" required>
                  <br>
                  <label>Via Pengiriman</label>
                  <input type="text" class="form-control" placeholder="" name="via_kirim" required>
                  <br>
                  <label>Estimasi Barang Sampai</label>
                  <input type="date" class="form-control" placeholder="" name="estimasi_brg_sampai">
                  <br>
                  <label>Biaya Jasa</label>
                  <input type="text" class="form-control" placeholder="" name="biaya_kirim" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

                </div>
                <div class="box-footer">
                  <button name="kirim_barang" type="submit" class="btn btn-success">Next</button>
                </div>
              </form>

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
$q = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pembeli.id=" . $_GET['id'] . ""))
?>
<div id="openDetailPembeli" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Detail RS/Dinas/Klinik/Dll</h3>
    <form method="post">
      <label>Nama RS/Dinas/Puskesmas/Klinik/Dll</label>
      <input id="input" type="text" placeholder="" name="no_peng" readonly="readonly" disabled value="<?php echo $q['nama_pembeli']; ?>">
      <label>Alamat</label>
      <textarea rows="4" id="input" placeholder="" name="no_peng" readonly="readonly" disabled><?php echo "Kelurahan " . $q['kelurahan_id'] . "\nKecamatan " . $q['nama_kecamatan'] . " \nKabupaten " . $q['nama_kabupaten'] . "\nProvinsi " . $q['nama_provinsi']; ?></textarea>
      <label>Kontak</label>
      <input id="input" type="text" placeholder="" name="no_po" readonly="readonly" disabled value="<?php echo $q['kontak_rs']; ?>">
      <br />
      <br />
    </form>
  </div>
</div>

<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=jual_alkes"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=jual_alkes2"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
  </div>
</div>