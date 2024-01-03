<?php
if (isset($_POST['pencarian'])) {
  if ($_POST['pilihan'] == 'tgl_riwayat') {
    echo "<script>window.location='index.php?page=data_riwayat_panggilan&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&tampil=$_POST[tampil]'</script>";
  } else {
    echo "<script>window.location='index.php?page=data_riwayat_panggilan&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]&tampil=$_POST[tampil]'</script>";
  }
}

if (isset($_GET['id_b_s'])) {
  $q = mysqli_query($koneksi, "update barang_dikirim set tgl_sampai='' where id=" . $_GET['id_b_s'] . "");
  if ($q) {
    echo "<script>window.location='index.php?page=kirim_barang'</script>";
  }
}
if (isset($_GET['id_hapus'])) {
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim,barang_dikirim_detail,barang_teknisi_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=" . $_GET['id_hapus'] . ""));
  if ($cek == 0) {
    $up = mysqli_query($koneksi, "update barang_gudang_detail,barang_dikirim_detail set barang_gudang_detail.status_kirim=0 where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $_GET['id_hapus'] . "");
    $jml_sel = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail where barang_dikirim_id=" . $_GET['id_hapus'] . ""));
    $up2 = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail,barang_dikirim_detail set stok_total=stok_total+$jml_sel where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $_GET['id_hapus'] . "");
    $del1 = mysqli_query($koneksi, "delete from barang_dikirim_detail where barang_dikirim_id=" . $_GET['id_hapus'] . "");
    $del2 = mysqli_query($koneksi, "delete from barang_dikirim where id=" . $_GET['id_hapus'] . "");
    if ($up and $up2 and $del1 and $del2) {
      echo "<script>
		alert('Data berhasil di hapus');
		window.location='index.php?page=kirim_barang'</script>";
    } else {
      echo "<script>
		alert('Data tidak dapat di hapus karena sudah dibuat SPI');
		window.location='index.php?page=kirim_barang'</script>";
    }
  } else {
    echo "<script>
		alert('Data tidak dapat di hapus karena sudah dibuat SPI');
		window.location='index.php?page=kirim_barang'</script>";
  }
  //$q2 = mysqli_query($koneksi, "select * from barang_dikirim,barang_dikirm_detail,barang_gudang_detail,barang_gudang where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim.id=".$_GET['id_hapus']."");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Riwayat Panggilan
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Riwayat Panggilan</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12">
        <div class="box box-body">

          <div class="pull pull-left">
            <table>
              <tr>
                <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                <td valign="top">1. </td>
                <td valign="top"><strong style="color:#F00">Tanggal Sampai</strong> wajib diisi , untuk pembuatan SPI </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td valign="top">2. </td>
                <td>Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                  barang telah dikembalikan karena mengalami kerusakan</td>
              </tr>
            </table>
          </div>
          <div class="pull pull-right">
            <?php include "include/getFilter.php"; ?>
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
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<?php
if (isset($_POST['sampai_barang'])) {
  $tgl_k = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dikirim where id=" . $_GET['id'] . ""));
  if ($_POST['tgl_sampai'] >= $tgl_k['tgl_kirim']) {
    $que = mysqli_query($koneksi, "update barang_dikirim set tgl_sampai='" . $_POST['tgl_sampai'] . "' where id=" . $_GET['id'] . "");
    if ($que) {
      //mysqli_query($koneksi, "insert into uji_f_i values('','".$_GET['id']."','0','0','')");
      echo "<script type='text/javascript'>
		  window.location='index.php?page=kirim_barang'
		  </script>";
    }
  } else {
    echo "<script type='text/javascript'>alert('Tanggal Sampai Tidak Boleh Kurang Dari Tanggal Pengiriman !');
		  </script>";
  }
}
?>
<div id="openSampai" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Status Alkes</h3>
    <?php $d = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dikirim where id=" . $_GET['id'] . "")); ?>
    <form method="post">
      <label>Tanggal Sampai</label>
      <input id="input" type="date" placeholder="" name="tgl_sampai" required value="<?php echo $d['tgl_sampai']; ?>">
      <!--<label>Keterangan</label>
     <textarea rows="4" id="input" type="text" placeholder="Keterangan" name="keterangan"><?php echo $d['ket_brg']; ?></textarea>-->
      <button id="buttonn" name="sampai_barang" type="submit">Simpan</button>
    </form>
  </div>
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
      <br /><br />
    </form>
  </div>
</div>

<div class="modal fade" id="modal-pencarian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <script type="text/javascript">
          function yesnoCheck() {
            if (document.getElementById('yesCheck').value == 'tgl_riwayat') {
              document.getElementById('ifYes').style.display = 'block';
              document.getElementById('kata_kunci').style.display = 'none';
            } else {
              document.getElementById('ifYes').style.display = 'none';
              document.getElementById('kata_kunci').style.display = 'block';
            }
          }
        </script>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pencarian</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select class="form-control select2" name="pilihan" required style="width:100%" onchange="javascript:yesnoCheck();" id="yesCheck">
            <option value="">...</option>
            <option value="tgl_riwayat">Berdasarkan Rentang Tanggal Panggilan</option>
            <option value="no_pengiriman">Berdasarkan Nomor Surat Jalan</option>
            <option value="barang_dijual.no_po_jual">Berdasarkan Nomor PO</option>
            <option value="nama_pembeli">Berdasarkan Lokasi Tujuan</option>
            <option value="nama_brg">Berdasarkan Nama Barang</option>
            <option value="tipe_brg">Berdasarkan Tipe Barang</option>
            <option value="no_seri_brg">Berdasarkan No Seri Barang</option>
          </select>
          <br /><br />
          <div id="kata_kunci" style="display:block">
            <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
          </div>
          <div id="ifYes" style="display:none">
            <label>Dari Tanggal</label>
            <input name="tgl1" type="date" class="form-control" placeholder="" value=""><br />
            <label>Sampai Tanggal</label>
            <input name="tgl2" type="date" class="form-control" placeholder="" value="">
          </div>
          <br />
          <select name="tampil" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <option value="1">Tampilkan Detail Barang</option>
            <option value="0">Jangan Tampilkan Detail Barang</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Cari</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>