<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_GET['id'] . ""));
$cekJml = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dijual where no_po_jual = '" . $data['no_po_jual'] . "' and status_deal = 1"));
$data2 = mysqli_fetch_array(mysqli_query($koneksi, "select id from barang_dijual where no_po_jual = '" . $data['no_po_jual'] . "' and status_deal = 1"));
$data3 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from barang_dijual where no_po_jual = '" . $data['no_po_jual'] . "'"));
if ($cekJml['jml'] > 0) {
  $reload = $data2['id'];
} else {
  $reload = $data3['idd'];
}
/*
if (isset($_POST['ubah_qty'])) {
	$Result = mysqli_query($koneksi, "update barang_dijual_qty set qty_jual=".$_POST['qty']." where id=".$_POST['id_ubahitem']."");
	if ($Result) {
		$jml = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id=".$_GET['id'].""));
		  mysqli_query($koneksi, "update barang_dijual set total_harga=$jml[total]+($jml[total]*ppn_jual/100)-($jml[total]*diskon_jual/100) where id=".$_GET['id']."");
		echo "<script type='text/javascript'>
		alert('Data Berhasil Di Ubah !');
		window.location='index.php?page=ubah_jual_barang_uang&id=$_GET[id]';
		</script>";
		}
	}
*/

if (isset($_POST['tambah_laporan'])) {
  $Result = mysqli_query($koneksi, "insert into aksesoris values('','" . $_POST['nama_akse'] . "','" . $_POST['merk'] . "','" . $_POST['tipe'] . "','" . $_POST['no_seri'] . "','" . $_POST['stok'] . "', '" . $_POST['deskripsi'] . "','" . $_POST['harga_satuan'] . "')");
  if ($Result) {
    echo "<script type='text/javascript'>
		alert('Data Berhasil Di Tambah !');
		window.location='index.php?page=simpan_tambah_aksesoris&id=$_GET[id]';
		</script>";
  }
}

if (isset($_POST['tambah_header'])) {
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . ""));
  if ($cek != 0) {
    //$insert_pembeli=mysqli_query($koneksi, "insert into pembeli values('','".$_SESSION['pembeli']."','".$_SESSION['provinsi']."','".$_SESSION['kabupaten']."','".$_SESSION['kecamatan']."','".$_SESSION['kelurahan']."','".$_SESSION['alamat']."','".$_SESSION['kontak_rs']."')");

    $insert_pemakai = mysqli_query($koneksi, "insert into pemakai values('','" . $_SESSION['pemakai'] . "','" . $_SESSION['kontak1'] . "','" . $_SESSION['kontak2'] . "','" . $_SESSION['email'] . "')");

    //$pembeli=mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pembeli from pembeli"));
    $id_pembeli = $_SESSION['pembeli'];
    $pemakai = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pemakai from pemakai"));
    $id_pemakai = $pemakai['id_pemakai'];
    //simpan barang dijual
    $total = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . ""));

    $simpan1 = mysqli_query($koneksi, "insert into barang_dijual values('','" . $_SESSION['tgl_jual'] . "','" . $_SESSION['no_faktur'] . "','$id_pembeli','$id_pemakai','" . $_SESSION['marketing'] . "','" . $_SESSION['subdis'] . "','" . $_SESSION['diskon'] . "','" . $_SESSION['ppn'] . "','" . $_POST['nominal'] . "')");

    $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_jual from barang_dijual"));
    $id_jual = $d1['id_jual'];
    //simpan barang pesan detail
    $q2 = mysqli_query($koneksi, "select * from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . "");
    while ($d2 = mysqli_fetch_array($q2)) {
      $simpan2 = mysqli_query($koneksi, "insert into barang_dijual_qty values('','$id_jual','" . $d2['barang_gudang_id'] . "','" . $d2['harga_jual_saat_itu'] . "','" . $d2['qty'] . "','0')");
      //$up=mysqli_query($koneksi, "update barang_gudang_detail set status_terjual=1 where id=".$d2['barang_gudang_detail_id']."");
      //$up2=mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=".$d2['barang_gudang_detail_id']."");
    }
    if ($simpan1 and $simpan2) {
      $Result = mysqli_query($koneksi, "insert into utang_piutang values('','Piutang','" . $_SESSION['no_faktur'] . "','" . $_POST['tgl_input'] . "','" . $_POST['jatuh_tempo'] . "','" . $_POST['nominal'] . "','" . $_POST['klien'] . "','" . $_POST['deskripsi'] . "','0')");
      mysqli_query($koneksi, "delete from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . "");
      echo "<script type='text/javascript'>
	alert('Data Berhasil Di Simpan !');
	window.location='index.php?page=jual_barang_uang'</script>";
    }
  } else {
    echo "<script type='text/javascript'>
	alert('Data tidak boleh kosong , silakan tambah terlebih dahulu ! !');
	window.location='index.php?page=simpan_jual_alkes2'</script>";
  }
}

if (isset($_POST['tambah_riwayat'])) {

  $sel = mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['riwayat'] . "");
  $dt_sel = mysqli_fetch_array($sel);
  $simpan1 = mysqli_query($koneksi, "insert into barang_dijual values('','" . $dt_sel['tgl_jual'] . "','" . $dt_sel['no_po_jual'] . "','" . $dt_sel['no_kontrak'] . "','" . $dt_sel['pembeli_id'] . "','" . $dt_sel['pemakai_id'] . "','" . $dt_sel['marketing'] . "','" . $dt_sel['subdis'] . "','" . $dt_sel['ongkir'] . "','" . $dt_sel['diskon_jual'] . "','" . $dt_sel['total_harga'] . "','" . $dt_sel['ppn_jual'] . "','" . $dt_sel['pph'] . "','" . $dt_sel['zakat'] . "','" . $dt_sel['biaya_bank'] . "','" . $dt_sel['neto'] . "','0','0')");

  $id_max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from barang_dijual"));
  $sel2 = mysqli_query($koneksi, "select * from barang_dijual_qty where barang_dijual_id=" . $_POST['riwayat'] . "");
  while ($dt = mysqli_fetch_array($sel2)) {
    $simpan2 = mysqli_query($koneksi, "insert into barang_dijual_qty values('','" . $id_max['idd'] . "','" . $dt['barang_gudang_id'] . "','" . $dt['harga_jual_saat_itu'] . "','" . $dt['qty_jual'] . "','" . $dt['okr'] . "','0')");
    $id_max_d = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from barang_dijual_qty"));
    $sel2_d = mysqli_query($koneksi, "select * from barang_dijual_qty_detail where barang_dijual_qty_id=" . $dt['id'] . "");
    while ($dtt = mysqli_fetch_array($sel2_d)) {
      $simpan3 = mysqli_query($koneksi, "insert into barang_dijual_qty_detail values('','" . $id_max_d['idd'] . "','" . $dtt['barang_gudang_id'] . "','" . $dtt['harga_jual_saat_itu'] . "','" . $dtt['jml_satuan'] . "','" . $dtt['jml_total'] . "')");
    }
  }
  if ($simpan1 and $simpan2) {
    echo "<script>
		alert('Riwayat berhasil di tambahkan !');
		window.location='index.php?page=ubah_jual_barang_uang&id=$_GET[id]'</script>";
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ubah Penjualan Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Ubah Penjualan Alkes</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
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
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <button class="btn btn-info pull pull-right" data-toggle="modal" data-target="#modal-ubah-harga" onclick="getNamaBarang2()"><i class="fa fa-edit"></i> Perubahan Harga Jual</button>
                <button name="waw" class="btn btn-success pull pull-left" type="button" data-toggle="modal" data-target="#modal-ubah-umum"><span class="fa fa-edit"></span> Ubah Data Umum</button>
                <br /><br />
                <div id="data-umum"></div>
                <br />
                <input type="hidden" id="id_pilih" class="form-control" value="">
                <div class="table-responsive no-padding">
                  <!-- Custom Tabs -->
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <?php
                      $que = mysqli_query($koneksi, "select * from barang_dijual where no_po_jual='" . $data['no_po_jual'] . "' order by id ASC");
                      $jm_riwayat = mysqli_num_rows($que);
                      $jm_deal1 = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dijual where no_po_jual='" . $data['no_po_jual'] . "' and status_deal=1 order by id ASC"));
                      $no2 = 0;
                      while ($dt = mysqli_fetch_array($que)) {
                        $no2++;
                      ?>
                        <li <?php if ($jm_deal1['jml'] != 0) {
                              if ($dt['status_deal'] == 1) {
                                echo "class='active'";
                              }
                            } else {
                              if ($no2 == $jm_riwayat) {
                                echo "class='active'";
                              } else {
                                echo "";
                              }
                            }; ?>><a href="#tab_<?php echo $dt['id']; ?>" onclick="reloadBarang('<?php echo $dt['id']; ?>');" data-toggle="tab">Riwayat <?php echo $no2; ?> <?php if ($dt['status_deal'] == 1) {
                                                                                                                                                                              echo "<i class='fa fa-check'></i>";
                                                                                                                                                                            } ?></a></li>
                      <?php } ?>
                      <?php
                      $jm_deal = mysqli_fetch_array(mysqli_query($koneksi, "select COUNT(*) as jml from barang_dijual where no_po_jual='" . $data['no_po_jual'] . "' and status_deal=1 order by id ASC"));
                      if ($jm_deal['jml'] == 0) {
                      ?>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modal-riwayat"><i class="fa fa-calendar"></i> &nbsp;Tambah Riwayat</button>
                      <?php } else { ?>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modal-teks-riwayat"><i class="fa fa-calendar"></i> &nbsp;Tambah Riwayat</button>
                      <?php } ?>
                    </ul>
                    <div id="isi_barang_jual"></div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- nav-tabs-custom -->
                </div>
                <br />

                <center><a href="index.php?page=jual_barang_uang">
                    <button name="batal" class="btn btn-success" type="button"><span class="fa  fa-check"></span> Kembali Ke Halaman Sebelumnya</button></a>
                </center>
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

?>
<div id="open_piutang" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Piutang</h3>
    <script type="text/javascript">
      function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
          document.getElementById('ifYes').style.display = 'block';
        } else document.getElementById('ifYes').style.display = 'none';
      }
    </script>
    <form method="post">
      <label>No PO</label>
      <input name="no_faktur" class="form-control" type="text" placeholder="" disabled="disabled" value="<?php echo $_SESSION['no_faktur']; ?>"><br />
      <label>Tanggal</label>
      <input name="tgl_input" class="form-control" type="date" placeholder="" required="required" value="<?php echo $_SESSION['tgl_jual']; ?>"><br />
      <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" style="height:20px; width:20px" checked="checked"><label>Tidak Ada Jatuh Tempo</label><br /><input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" style="height:20px; width:20px"><label>Jatuh Tempo</label>
      <br />
      <div id="ifYes" style="display:none">
        <label>Tanggal Jatuh Tempo</label>
        <input name="jatuh_tempo" type="date" class="form-control" placeholder="" value=""><br />
      </div>

      <label>Nominal</label>
      <input name="nominal" class="form-control" type="text" placeholder="" value="<?php echo $total2; ?>" required="required"><br />
      <label>Klien</label>
      <input name="klien" class="form-control" type="text" placeholder="" value="<?php echo $sel['nama_pembeli'];  ?>" required="required"><br />
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4"></textarea>
      <br />
      <br />
      <!--
              <label>Akun</label>
              <select name="akun" id="akun" class="form-control" required>
              <option value="">-- Pilih --</option>
              <?php
              $q = mysqli_query($koneksi, "select * from coa order by nama_akun ASC");
              while ($d = mysqli_fetch_array($q)) {
              ?>
              <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_akun']; ?></option>
              <?php } ?>
              </select><br />
              <label>Jenis</label>
              <select name="jenis_akun" id="jenis_akun" class="form-control" required>
    <option value="">--Jenis--</option>
    <?php
    $q_seri = mysqli_query($koneksi, "select *,coa_detail.id as idd,coa_detail.nama_akun as nama from coa_detail INNER JOIN coa ON coa.id=coa_detail.coa_id order by coa_detail.nama_akun ASC");
    while ($d_seri = mysqli_fetch_array($q_seri)) {
    ?>
    <option id="jenis_akun" value="<?php echo $d_seri['idd']; ?>" class="<?php echo $d_seri['coa_id']; ?>"><?php echo $d_seri['nama']; ?></option>
    <?php } ?>
    </select>
              <script src="jquery-1.10.2.min.js"></script>
        <script src="jquery.chained.min.js"></script>
        <script>
            $("#jenis_akun").chained("#akun");
        </script>
        -->

      <button name="tambah_header" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
    </form>

  </div>
</div>

<div class="modal fade" id="modal-ubah-umum">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Data Umum</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanDataUmum(); return false;">
        <div class="modal-body">
          <label>Tanggal Jual</label>
          <input type="date" name="tgl_jual" id="tgl_jual" value="<?php echo $data['tgl_jual']; ?>" class="form-control" />
          <br />
          <label>No PO</label>
          <input type="text" name="no_po" id="no_po" value="<?php echo $data['no_po_jual']; ?>" class="form-control" />
          <br />
          <label>No Kontrak</label>
          <input type="text" name="no_kontrak" id="no_kontrak" value="<?php echo $data['no_kontrak']; ?>" class="form-control" />
          <br />
          <label>Nama RS/Dinas/Puskesmas/Klinik/Dll</label>
          <div class="form-group">
            <select name="pembeli" id="pembeli" onchange="changeValue(this.value)" required class="form-control select2" style="width:100%">
              <option value="">...</option>

              <?php
              $result = mysqli_query($koneksi, "select pembeli.id as idd, nama_pembeli, kelurahan_id, jalan, kontak_rs from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id group by nama_pembeli order by nama_pembeli ASC");
              // $jsArray = "var dtPembeli = new Array();
              // ";
              while ($row = mysqli_fetch_array($result)) {
              ?>
                <option <?php if ($data['pembeli_id'] == $row['idd']) {
                          echo "selected";
                        } ?> value="<?php echo $row['idd']; ?>"><?php echo $row['nama_pembeli']; ?></option>
              <?php

                // $jsArray .= "dtPembeli['" . $row['idd'] . "'] = {nama_pembeli:'" . addslashes($row['nama_pembeli']) . "',
                //                       kelurahan:'" . addslashes($row['kelurahan_id']) . "',
                //                       jalan:'" . addslashes(substr($row['jalan'], 0, 17) . ".....") . "',
                //                       kontak_rs:'" . addslashes($row['kontak_rs']) . "'
                //                       };
                //             ";
              }
              ?>
            </select>
          </div>
          <!-- <div class="well">
            <div class="box-header" align="center"><strong>Alamat RS/Dinas/Puskesmas/Klinik/Dll</strong></div>
            <input class="form-control" type="hidden" name="nama_pembeli" id="nama_pembeli">
            Kelurahan
            <input class="form-control" type="text" placeholder="" name="kelurahan" id="kelurahan" disabled="disabled"><br />
            Alamat Jalan
            <input class="form-control" type="text" placeholder="" name="jalan" id="jalan" disabled="disabled"><br />
            Kontak RS/Dinas/Dll
            <input class="form-control" type="text" placeholder="" name="kontak_rs" required id="kontak_rs" disabled="disabled" ><br />
          </div> -->
          <?php
          $sel_pemakai = mysqli_fetch_array(mysqli_query($koneksi, "select * from pemakai where id=" . $data['pemakai_id'] . ""));
          ?>
          <label>Nama Pemakai</label>
          <input type="text" name="nama_pemakai" id="nama_pemakai" value="<?php echo $sel_pemakai['nama_pemakai']; ?>" class="form-control" />
          <br />
          <label>Kontak Pemakai (1)</label>
          <input type="text" id="kontak1" value="<?php echo $sel_pemakai['kontak1_pemakai']; ?>" name="kontak1" class="form-control" />
          <br />
          <label>Kontak Pemakai (2)</label>
          <input type="text" name="kontak2" id="kontak2" value="<?php echo $sel_pemakai['kontak2_pemakai']; ?>" class="form-control" />
          <br />
          <label>Email Pemakai</label>
          <input type="email" name="email_pemakai" id="email_pemakai" value="<?php echo $sel_pemakai['email_pemakai']; ?>" class="form-control" />
          <br />
          <label>Marketing</label>
          <select required="required" name="marketing" id="marketing" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <?php $s = mysqli_query($koneksi, "select nama_marketing from marketing order by nama_marketing ASC");
            while ($d_s = mysqli_fetch_array($s)) { ?>
              <option <?php if ($data['marketing'] == $d_s['nama_marketing']) {
                        echo "selected";
                      } ?> value="<?php echo $d_s['nama_marketing']; ?>"><?php echo $d_s['nama_marketing']; ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label>Subdis</label>
          <textarea class="form-control" name="subdis" id="subdis" required rows="5" placeholder="Gunakan [ENTER] untuk melainkan kalimat pertama dan kalimat berikutnya"><?php echo str_replace("<br>", "\n", $data['subdis']); ?></textarea>
          <br />
          <label>Riwayat Po yang deal</label>
          <select name="status_deal" id="status_deal" class="form-control select2" style="width:100%">
            <option <?php if ($jm_deal == 0) {
                      echo "selected";
                    } ?> value="0">Belum Ada</option>
            <?php $s2 = mysqli_query($koneksi, "select id, status_deal from barang_dijual where no_po_jual='" . $data['no_po_jual'] . "' order by id ASC");
            $nn = 0;
            while ($d_s = mysqli_fetch_array($s2)) {
              $nn++; ?>
              <option <?php if ($d_s['status_deal'] == 1) {
                        echo "selected";
                      } ?> value="<?php echo $d_s['id']; ?>"><?php echo "Riwayat " . $nn; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan_pemakai">Simpan</button>
        </div>
        <!-- <script type="text/javascript">
          <?php
          //echo $jsArray;
          ?>
          function changeValue(pembeli) {
            document.getElementById('nama_pembeli').value = dtPembeli[pembeli].nama_pembeli;
            document.getElementById('kelurahan').value = dtPembeli[pembeli].kelurahan;
            document.getElementById('jalan').value = dtPembeli[pembeli].jalan;
            document.getElementById('kontak_rs').value = dtPembeli[pembeli].kontak_rs;
          };
        </script> -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah-harga">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ubah Harga Barang</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="ubahHargaBarang(); return false;">
        <div class="modal-body">
          <label>Nama Barang</label>
          <div id="nama_barang2"></div>
          <br />
          <label>Harga Barang</label>
          <input id="harga_brg" name="harga_brg" class="form-control" type="text" placeholder="" value="" required="required" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubah_harga" class="btn btn-info" type="submit"><span class="fa fa-check"></span> Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-riwayat">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Riwayat</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <label>Gunakan Data Dari Riwayat ke-</label>
          <select required name="riwayat" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <?php $s3 = mysqli_query($koneksi, "select id from barang_dijual where no_po_jual='" . $data['no_po_jual'] . "' order by id ASC");
            $nm = 0;
            while ($d_s = mysqli_fetch_array($s3)) {
              $nm++; ?>
              <option value="<?php echo $d_s['id']; ?>"><?php echo "Riwayat " . $nm; ?></option>
            <?php } ?>
          </select>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="tambah_riwayat" class="btn btn-warning" type="submit"><span class="fa fa-check"></span> Tambah Riwayat</button>
        </div>
      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-teks-riwayat">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Peringatan !</h4>
      </div>
      <div class="modal-body">
        Silakan Ubah Dulu Riwayat PO Deal Menjadi Belum Ada Untuk Menambah Riwayat (Pilih Ubah Data Umum di Pojok Kanan Atas)
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>


    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center"><strong>Tambah Data</strong></h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="tambahBarangJual('<?php echo $reload; ?>'); return false;">
        <div class="modal-body">
          <input type="hidden" id="idd" name="idd" value="<?php echo $_GET['id'] ?>" />
          <label>Nama Barang</label>
          <div id="nama_barang"></div>
          <br />
          <label>Kategori Barang</label>
          <input id="kategori_brg" name="kategori_brg" class="form-control" type="text" placeholder="Kategori" disabled="disabled" size="4" />
          <br />
          <div class="form-group" id="include-aksesoris" style="display: none;">
            <label class="col-lg-6 no-padding">
              <input type="radio" name="r3" id="no_include" value="0" class="flat-red" checked style="width: 20px;">
              Tidak Include Aksesoris
            </label>
            <label class="col-lg-6">
              <input type="radio" name="r3" id="yes_include" value="1" class="flat-red" style="width: 20px;">
              Include Aksesoris
            </label>
            <br>
          </div>
          <label>Stok Total</label>
          <input id="stok_total" name="stok_total" class="form-control" type="text" placeholder="Stok" disabled="disabled" size="4" />
          <br />
          <label>Harga (<font size="-2" color="#FF0000">Harga tidak boleh 0</font>)</label>
          <input id="harga" name="harga" class="form-control" type="text" placeholder="Harga" disabled="disabled" size="8" />
          <br />
          <label>Tipe</label>
          <input id="tipe_brg" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled" size="15" />
          <br />
          <label>Merk</label>
          <input id="merk_brg" name="merk_brg" class="form-control" type="text" placeholder="Merk" disabled="disabled" size="15" />
          <br />
          <label>Qty</label>
          <input id="qty_jual" name="qty" class="form-control" type="number" placeholder="" size="2" />
          <br />
          <label>Ongkir</label>
          <input id="ongkir_jual" name="ongkirr" class="form-control" type="text" placeholder="" size="2" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" />
          <br />
          <label>Total</label>
          <input id="" name="total" class="form-control" type="text" placeholder="" size="" value="Auto" disabled="disabled" />
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahitem">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Kuantitas</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="ubahDataQty(); return false;">
        <div class="modal-body">
          <p align="justify">
            <input type="hidden" name="id_barang_jual" id="id_barang_jual" />
            <input type="hidden" name="id_ubahitem" id="id_ubahitem" />
            <input id="qty_ubah_jual" name="qty" class="form-control" type="number" placeholder="">
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubah_qty" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detail-jual">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">
          <strong>
            <div id="detail-jual-title"></div>
          </strong>
        </h4>
      </div>
      <div class="modal-body">
        <div class="rows">
          <div class="pull pull-left">
            <div class="text-left">
              <button class="btn btn-sm btn-success" onclick="modalTambahDetail();"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </div>
          <div class="pull pull-right">
            <div class="text-right" id="jumlah_set"></div>
          </div>
        </div>
        <br><br>
        <div id="data-detail-jual"></div>
      </div>

      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
        <button name="simpan_tambah_aksesoris" class="btn btn-success" data-dismiss="modal"><span class="fa fa-check"></span> OK</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-lainnya">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nilai Ongkir, Diskon, PPN, PPh, Lain-lain</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanLainnya($('#id_pilih').val()); return false;">
        <div class="modal-body">
          <input type="hidden" name="idd" value="<?php echo $dt['id'] ?>" />
          <label>Ongkir</label>
          <input id="ongkir" name="ongkir" class="form-control" type="text" placeholder="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          <br />
          <label>Diskon</label>
          <input id="diskon" name="diskon" class="form-control" type="text" placeholder="Gunakan Tanda '.' Untuk Koma">
          <br />
          <label>PPN (%)</label>
          <input id="ppn" name="ppn" class="form-control" type="text" placeholder="Gunakan Tanda '.' Untuk Koma">
          <br />
          <label>PPh (%)</label>
          <input id="pph" name="pph" class="form-control" type="text" placeholder="Gunakan Tanda '.' Untuk Koma">
          <br />
          <label>Zakat (%)</label>
          <input id="zakat" name="zakat" class="form-control" type="text" placeholder="Gunakan Tanda '.' Untuk Koma">
          <br />
          <label>Biaya Bank</label>
          <input id="biaya_bank" name="biaya_bank" class="form-control" type="text" placeholder="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          <br />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="input_ongkir" class="btn btn-info" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubah-detail2" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center"><strong>Ubah Data Rincian</strong></h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanUbahDetail(); return false;">
        <div class="modal-body">
          <input id="id_ubah_brg" type="hidden">
          <input id="id_qty_brg" type="hidden">
          <label>Nama Barang</label>
          <div id="nama_barang3"></div>
          <br />
          <label>Qty</label>
          <input id="qty_jual3" name="qty" class="form-control" type="number" placeholder="" size="2" />
          <br />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="sasdas" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-tambah-detail" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center"><strong>Tambah Data Rincian</strong></h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanTambahDetail(); return false;">
        <div class="modal-body">
          <input id="id_jual4" type="hidden">
          <label>Nama Barang</label>
          <div id="nama_barang4"></div>
          <br />
          <label>Qty</label>
          <input id="qty_jual4" name="qty" class="form-control" type="number" placeholder="" size="2" />
          <br />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="sasdas" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function simpanTambahDetail() {
    $.post("data/simpan-detail-jual.php", {
        id_gudang: $('#id_akse4').val(),
        qty: $('#qty_jual4').val(),
        id_jual: $('#id_jual4').val()
      },
      function(data) {
        if (data == 'S') {
          $.get("data/data_detail_jual.php", {
              id: $('#id_jual4').val(),
            },
            function(data) {
              $('#data-detail-jual').html(data);
            }
          );
          $('#modal-tambah-detail').modal('hide');
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    );
  }

  function simpanUbahDetail() {
    $.post("data/ubah-detail-jual.php", {
        id_gudang: $('#id_akse3').val(),
        qty: $('#qty_jual3').val(),
        id: $('#id_ubah_brg').val()
      },
      function(data) {
        if (data == 'S') {
          $.get("data/data_detail_jual.php", {
              id: $('#id_qty_brg').val(),
            },
            function(data) {
              $('#data-detail-jual').html(data);
            }
          );
          $('#modal-ubah-detail2').modal('hide');
          alertCustom('S', 'Perubahan Berhasil Disimpan !', '')
        } else {
          alertCustom('F', 'Perubahan Gagal Disimpan !', '')
        }
      }
    );
  }

  function modalUbahDetail(id_ubah, id_qty, kategori, jml, id_gudang) {
    $('#id_ubah_brg').val(id_ubah);
    $('#id_qty_brg').val(id_qty);
    $('#qty_jual3').val(jml);
    $('#nama_barang3').html('<center><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></center>');
    $.get("data/get_nama_barang3.php", {
        kategori: kategori == 'Set' ? 'Satuan' : 'Aksesoris',
        id: id_gudang
      },
      function(data) {
        $('#nama_barang3').html(data);
      }
    );
    $('#modal-ubah-detail2').modal('show');
  }

  function modalTambahDetail() {
    var id_jual = $('#id_ubahh').val();
    $('#id_jual4').val(id_jual);
    var kate = $('#kategorii').val();
    $('#nama_barang4').html('<center><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></center>');
    $.get("data/get_nama_barang4.php", {
        kategori: kate == 'Set' ? 'Satuan' : 'Aksesoris',
        id_jual: id_jual
      },
      function(data) {
        $('#nama_barang4').html(data);
      }
    );
    $('#modal-tambah-detail').modal('show');
  }

  function hapusRiwayat(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Riwayat PO Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus_riwayat.php", {
            id: '<?php echo $_GET['id'] ?>',
            id_hapus: id
          },
          function(data) {
            location.reload(true);
          }
        );
      }
    })
  }

  function simpanLainnya(id) {
    loading_data('#isi_barang_jual');
    $.post("data/ubah_barang_jual_lainnya.php", {
        idd: id,
        ongkir: $('#ongkir').val(),
        diskon: $('#diskon').val(),
        ppn: $('#ppn').val(),
        pph: $('#pph').val(),
        zakat: $('#zakat').val(),
        biaya_bank: $('#biaya_bank').val(),
      },
      function(data) {
        $('#modal-lainnya').modal('hide');
        // if (data == 'S') {
        //   alert('Sukses')
        reloadBarang(id);
        // } else {
        //   alert('Gagal')
        // }
      }
    );
  }

  function openDetail(id, kategori, jml_set) {
    if (kategori == 'Set') {
      $('#detail-jual-title').html('Detail Rincian Barang Dalam 1 Set');
      $('#jumlah_set').html('<font style="font-size:18px;">Jumlah : ' + jml_set + ' Set</font>');
    } else if (kategori == 'Satuan') {
      $('#detail-jual-title').html('Detail Rincian Aksesoris Barang Per Satuan');
      $('#jumlah_set').html('<font style="font-size:18px;">Jumlah : ' + jml_set + ' Satuan</font>');
    }
    $.get("data/data_detail_jual.php", {
        id: id,
        id_barang_jual: $('#id_pilih').val(),
        kategori: kategori
      },
      function(data) {
        $('#data-detail-jual').html(data);
        $('#modal-detail-jual').modal('show');
      }
    );
  }

  function openUbah(idd, id_ubah, qty) {
    $('#id_barang_jual').val(idd);
    $('#id_ubahitem').val(id_ubah);
    $('#qty_ubah_jual').val(qty);
    $('#modal-ubahitem').modal('show');
  }

  function ubahDataQty(id_jual, id_ubah) {
    loading_data('#isi_barang_jual');
    $.post("data/ubah_qty_jual.php", {
        qty: $('#qty_ubah_jual').val(),
        id_ubahitem: $('#id_ubahitem').val(),
        id_barang_jual: $('#id_barang_jual').val(),
      },
      function(data) {
        if (data == 'S') {
          $('#modal-ubahitem').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-green',
              cancelButton: 'bg-white',
            },
            title: 'Berhasil Disimpan',
            icon: 'success',
            confirmButtonText: 'OK',
          });
          reloadBarang($('#id_pilih').val());
        } else {
          $('#modal-ubahitem').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-red',
              cancelButton: 'bg-white',
            },
            title: 'Gagal Disimpan',
            icon: 'error',
            confirmButtonText: 'OK',
          });
          reloadBarang($('#id_pilih').val());
        }
      }
    );
  }

  function hapusBarangJual(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Item Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        loading_data('#isi_barang_jual');
        $.post("data/hapus_jual_barang.php", {
            id_hapus: id,
            id_barang_jual: $('#id_pilih').val()
          },
          function(data) {
            reloadBarang($('#id_pilih').val());
          }
        );
      }
    })
  }

  function tambahBarangJual(id) {
    var no_include = $('#no_include').prop('checked');
    loading_data('#isi_barang_jual');
    $.post("data/tambah_barang_jual.php", {
        idd: $('#id_pilih').val(),
        id_akse: $('#id_akse').val(),
        qty: $('#qty_jual').val(),
        ongkirr: $('#ongkir_jual').val(),
        inc: no_include == true ? '0' : '1'
      },
      function(data) {
        if (data == 'S') {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-green',
              cancelButton: 'bg-white',
            },
            title: 'Berhasil Disimpan',
            icon: 'success',
            confirmButtonText: 'OK',
          });
        } else if (data == 'K') {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-yellow',
              cancelButton: 'bg-white',
            },
            title: 'Harga jual alat tidak boleh 0 , update harga jual nya terlebih dahulu !',
            icon: 'warning',
            confirmButtonText: 'OK',
          });
        } else if (data == 'SA') {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-red',
              cancelButton: 'bg-white',
            },
            title: 'Barang Sudah Ada !',
            icon: 'error',
            confirmButtonText: 'OK',
          });
        } else {
          $('#modal-tambah').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-red',
              cancelButton: 'bg-white',
            },
            title: 'Gagal Disimpan',
            icon: 'error',
            confirmButtonText: 'OK',
          });
        }
        reloadBarang($('#id_pilih').val());
      }
    );
  }

  function reloadBarang(id) {
    // loading_data('#isi_barang_jual');
    $('#id_pilih').val(id);
    $.get("data/isi_barang_jual.php", {
        id: id
      },
      function(data) {
        $('#isi_barang_jual').html(data);
      }
    );
  }

  function ubahHargaBarang() {
    var id_brg = $('#barang_id').val();
    var nominal = $('#harga_brg').val();

    $.post("data/ubah_harga_barang.php", {
        id_brg: id_brg,
        nominal: nominal
      },
      function(data) {
        if (data == 'S') {
          $('#modal-ubah-harga').modal('hide');
          $('#harga_brg').val('');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-green',
              cancelButton: 'bg-white',
            },
            title: 'Berhasil Disimpan',
            icon: 'success',
            confirmButtonText: 'OK',
          })
        } else {
          $('#modal-ubah-harga').modal('hide');
          $('#harga_brg').val('');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-red',
              cancelButton: 'bg-white',
            },
            title: 'Gagal Disimpan',
            icon: 'error',
            confirmButtonText: 'OK',
          })
        }
      }
    );
  }

  function simpanDataUmum(id) {
    $.post("data/simpan_data_umum.php", {
        id: '<?php echo $_GET['id'] ?>',
        pemakai_id: '<?php echo $data['pemakai_id'] ?>',
        no_po_jual: '<?php echo $data['no_po_jual'] ?>',
        ongkir: '<?php echo $data['ongkir'] ?>',
        ppn_jual: '<?php echo $data['ppn_jual'] ?>',
        pph: '<?php echo $data['pph'] ?>',
        zakat: '<?php echo $data['zakat'] ?>',
        biaya_bank: '<?php echo $data['biaya_bank'] ?>',
        nama_pemakai: $('#nama_pemakai').val(),
        kontak1: $('#kontak1').val(),
        kontak2: $('#kontak2').val(),
        email_pemakai: $('#email_pemakai').val(),
        tgl_jual: $('#tgl_jual').val(),
        no_po: $('#no_po').val(),
        no_kontrak: $('#no_kontrak').val(),
        pembeli: $('#pembeli').val(),
        marketing: $('#marketing').val(),
        subdis: $('#subdis').val(),
        status_deal: $('#status_deal').val(),

      },
      function(data) {
        if (data == 'S') {
          if ($('#status_deal').val() != '<?php echo $data['status_deal'] ?>') {
            location.reload(true);
          } else {
            $('#modal-ubah-umum').modal('hide');
            Swal.fire({
              customClass: {
                confirmButton: 'bg-green',
                cancelButton: 'bg-white',
              },
              title: 'Berhasil Disimpan',
              icon: 'success',
              confirmButtonText: 'OK',
            });
            loading_data_umum();
            getDataUmum('<?php echo $_GET['id'] ?>');
          }
        } else {
          $('#modal-ubah-umum').modal('hide');
          Swal.fire({
            customClass: {
              confirmButton: 'bg-red',
              cancelButton: 'bg-white',
            },
            title: 'Gagal Disimpan',
            icon: 'error',
            confirmButtonText: 'OK',
          })
        }
      }
    );
  }

  async function getNamaBarang2() {
    loading_data('#nama_barang2');
    await $.get("data/get_nama_barang2.php",
      function(data) {
        $('#nama_barang2').html(data);
      }
    );
  }

  function getNamaBarang() {
    loading_data('#nama_barang');
    $.get("data/get_nama_barang.php",
      function(data) {
        $('#nama_barang').html(data);
      }
    );
  }

  function loading_data_umum() {
    $.get("include/getLoading.php", function(data) {
      $('#data-umum').html(data);
    });
  }

  function loading_data(id) {
    $.get("include/getLoading.php", function(data) {
      $(id).html(data);
    });
  }

  function getDataUmum(id) {
    $.get("data/jual_data_umum.php", {
        id: id
      },
      function(data) {
        $('#data-umum').html(data);
      }
    );
  }

  function cekInclude() {
    if ($('#kategori_brg').val() == 'Satuan') {
      $('#include-aksesoris').show();
    } else {
      $('#include-aksesoris').hide();
    }
  }

  $(document).ready(function() {
    // loading_data('#isi_barang_jual');
    reloadBarang('<?php echo $reload; ?>')
    // loading_data_umum();
    getDataUmum('<?php echo $_GET['id'] ?>')
  });
</script>