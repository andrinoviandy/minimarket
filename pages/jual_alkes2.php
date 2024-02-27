<!--<script language="javascript">
  function showKabupaten() {
	  
	  <?php /*
	  
	  $query1=mysqli_query($koneksi, "select * from alamat_provinsi");
	  while ($d1=mysqli_fetch_array($query1)) {
		  $prov = $d1['id'];
		  echo "if (document.form1.provinsi.value == \"".$prov."\")";
		  echo "{";
		  $query2=mysqli_query($koneksi, "select * from alamat_kabupaten where provinsi_id=$prov order by nama_kabupaten ASC");
		  $content= "document.getElementById('kabupaten').innerHTML=\"";
		  while ($d2=mysqli_fetch_array($query2)) {
			  $content.= "<option value='".$d2['id']."'>".$d2['nama_kabupaten']."</option>";
			  $idd=$d2['id']; 
			  }
			  $content.="\"";
			  echo $content;
		  echo "}\n";
		  }
	  ?>
	  }
	  
  </script>
  
  <script language="javascript">
  function showKecamatan() {
	  <?php
	  $query4 = mysqli_query($koneksi, "select * from alamat_kecamatan");
	  while ($d4=mysqli_fetch_array($query4)) {
		$kabu=$d4['id'];
		echo "if (document.form1.kabupaten.value == \"".$kabu."\")";
		echo "{";
	  $query3=mysqli_query($koneksi, "select * from alamat_kecamatan where kabupaten_id=".$kabu."");
	  $content="document.getElementById('kecamatan').innerHTML=\"";
	  while ($d3=mysqli_fetch_array($query3)) {
		  $content.= "<option value=".$d3['id'].">".$d3['nama_kecamatan']."</option>";
		  }
		  $content.="\"";
		  echo $content;
		  echo "}\n";
  } */
    ?>
	  }
  </script>-->
<?php
if (isset($_POST['simpan_rs'])) {
  $insert_pembeli = mysqli_query($koneksi, "insert into pembeli values('','" . $_POST['nama_pembeli'] . "','" . $_POST['provinsi'] . "','" . $_POST['kabupaten'] . "','" . $_POST['kecamatan'] . "','" . $_POST['kelurahan'] . "','" . $_POST['alamat'] . "','" . $_POST['kontak_rs'] . "')");
  if ($insert_pembeli) {
    echo "<script>history.back(-1)</script>";
  }
}

if (isset($_POST['lapor'])) {
  $jml = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual where no_po_jual='" . $_POST['no_faktur'] . "'"));
  if ($jml == 0) {
    $q = mysqli_query($koneksi, "select * from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . "");
    while ($d = mysqli_fetch_array($q)) {
      mysqli_query($koneksi, "delete from barang_dijual_qty_detail_hash where id=" . $d['id'] . "");
    }
    mysqli_query($koneksi, "delete from barang_dijual_qty_hash where akun_id=" . $_SESSION['id'] . "");
    $_SESSION['tgl_jual'] = $_POST['tgl_jual'];
    $_SESSION['pembeli'] = $_POST['id_pembeli'];
    $_SESSION['provinsi'] = $_POST['provinsi'];
    $_SESSION['kecamatan'] = $_POST['kecamatan'];
    $_SESSION['kabupaten'] = $_POST['kabupaten'];
    $_SESSION['kelurahan'] = $_POST['kelurahan2'];
    $_SESSION['alamat'] = $_POST['jalan2'];
    $_SESSION['kontak_rs'] = $_POST['kontak_rs2'];
    $_SESSION['pemakai'] = $_POST['pemakai'];
    $_SESSION['kontak1'] = $_POST['kontak1'];
    $_SESSION['kontak2'] = $_POST['kontak2'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['marketing'] = $_POST['marketing'];
    $_SESSION['subdis'] = str_replace("\n", "<br>", $_POST['subdis']);
    $_SESSION['no_faktur'] = $_POST['no_faktur'];
    $_SESSION['no_kontrak'] = $_POST['no_kontrak'];
    $_SESSION['diskon'] = $_POST['diskon'];
    $_SESSION['ppn'] = $_POST['ppn'];
    $_SESSION['status_po'] = $_POST['status_po'];
    unset($_SESSION['ongkir']);
    unset($_SESSION['diskon']);
    unset($_SESSION['ppn']);
    unset($_SESSION['pph']);
    unset($_SESSION['zakat']);
    unset($_SESSION['biaya_bank']);
    echo "<script type='text/javascript'>
		window.location='index.php?page=simpan_jual_alkes2&dpp=$_POST[dpp]';
		</script>";
  } else {
    echo "<script type='text/javascript'>
		alert('Maaf NO PO sudah ada !');
		history.back();
		</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Jual Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Jual Alkes</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <form method="post" id="form_combo" enctype="multipart/form-data">

      <div class="row">
        <div class="col-md-6"><!-- /.box -->

          <!-- iCheck -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i>Isilah Data Dengan Benar</i></h3>
            </div>
            <div class="box-body">
              Tanggal Jual
              <input name="tgl_jual" type="date" class="form-control" required autofocus="autofocus" /><br />
              No PO Penjualan
              <input name="no_faktur" type="text" class="form-control" required /><br />
              No Kontrak
              <input name="no_kontrak" type="text" class="form-control" required /><br />
              Nama RS/Dinas/Puskesmas/Klinik/Dll
              <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <button type="button" class="btn btn-primary" onclick="modalPembeli();"><i class="fa fa-search"></i> Pilih RS/Dinas/Puskesmas/Klinik/Dll</button>
                </div>
                <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <button type="button" class="btn btn-success pull-right" onclick="modalTambahPembeli();"><i class="fa fa-plus"></i> Tambah Baru</button>
                </div> -->
              </div><br />
              <div class="well">
                <div class="box-header" align="center"><strong>Data RS/Dinas/Puskesmas/Klinik/Dll</strong></div>
                <input class="form-control" type="hidden" name="id_pembeli" id="id_pembeli">
                Nama RS/Dinas/Puskesmas/Klinik/Dll
                <input class="form-control" type="text" name="nama_pembeli2" id="nama_pembeli2" disabled="disabled"><br>
                Provinsi
                <input class="form-control" type="text" name="provinsi2" id="provinsi2" disabled="disabled"><input class="form-control" type="hidden" name="id_provinsi" id="id_provinsi"><br />

                Kabupaten
                <input class="form-control" type="text" name="kabupaten2" id="kabupaten2" disabled="disabled"><input class="form-control" type="hidden" name="id_kabupaten" id="id_kabupaten"><br />
                Kecamatan
                <input class="form-control" type="text" name="kecamatan2" id="kecamatan2" disabled="disabled"><input class="form-control" type="hidden" name="id_kecamatan" id="id_kecamatan"><br />
                Kelurahan
                <input class="form-control" type="text" placeholder="" name="kelurahan2" id="kelurahan2" readonly="readonly"><br />
                Alamat Jalan
                <input class="form-control" type="text" placeholder="" name="jalan2" id="jalan2" readonly="readonly"><br />
                Kontak RS/Dinas/Dll
                <input class="form-control" type="text" placeholder="" name="kontak_rs2" required id="kontak_rs2" readonly="readonly"><br />
              </div>
              <input class="form-control" type="hidden" id="pembeli" name="pembeli"><br />
              Nama Pemakai
              <input class="form-control" type="text" placeholder="Nama Pemakai" name="pemakai" required><br />
              Kontak 1 (Pemakai)
              <input class="form-control" type="text" placeholder="Kontak 1" name="kontak1" required><br />
              Kontak 2 (Pemakai)
              <input class="form-control" type="text" placeholder="Kontak 2" name="kontak2" required><br />
              Email (Pemakai)
              <input class="form-control" type="email" placeholder="XXX@xxxx.com" name="email"><br />
              Marketing
              <select required="required" name="marketing" class="form-control select2" style="width:100%">
                <option value="">...</option>
                <?php $s = mysqli_query($koneksi, "select * from marketing order by nama_marketing ASC");
                while ($d_s = mysqli_fetch_array($s)) { ?>
                  <option value="<?php echo $d_s['nama_marketing']; ?>"><?php echo $d_s['nama_marketing']; ?></option>
                <?php } ?>
              </select>
              <br /><br />
              Sub Distributor
              <textarea class="form-control" name="subdis" required rows="5" placeholder="Gunakan [ENTER] untuk melainkan kalimat pertama dan kalimat berikutnya"></textarea>
              <br />
              DPP
              <select required="required" name="dpp" class="form-control select2" style="width:100%">
                <option value="1">Include DPP</option>
                <option value="0">Tidak Include DPP</option>
              </select>
              <br><br>
              Status PO
              <select required="required" name="status_po" class="form-control select2" style="width:100%">
                <option value="0">Belum Deal</option>
                <option value="1">Sudah Deal</option>
              </select>
              <!--
              <br />
              Diskon (%)
              <input class="form-control" type="number" placeholder="Diskon" name="diskon" required><br />
              PPN (%)
              <input class="form-control" type="number" placeholder="PPN" name="ppn" required><br />
              -->
              <br /><br />
              <div class="col-lg-2 no-padding pull pull-right">
                <input name="lapor" type="submit" value="Next" class="form-control btn btn-success" />
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>

        <!-- /.content -->
      </div>
    </form>
  </section>
</div>

<div class="modal fade" id="modal-pembeli">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Data RS/Dinas/Klinik/Dll</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="modal-data-pembeli"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-tambahrs">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Data RS/Dinas/Puskesmas/Klinik/Dll</h4>
      </div>
      <div id="tambah-pembeli"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function loading_jual() {
    $.get("include/getLoading.php", function(data) {
      $('#modal-data-pembeli').html(data);
    });
  }

  function modalTambahPembeli() {
    $('#modal-tambahrs').modal('show');
    $.get("data/modal-tambah-pembeli.php",
      function (data) {
        $('#tambah-pembeli').html(data);
      }
    );
  }

  function pilihPembeli(id, nama, provinsi, kabupaten, kecamatan, kelurahan, jalan, kontak) {
    $('#id_pembeli').val(id);
    $('#nama_pembeli2').val(nama);
    $('#provinsi2').val(provinsi);
    $('#kabupaten2').val(kabupaten);
    $('#kecamatan2').val(kecamatan);
    $('#kelurahan2').val(kelurahan);
    $('#jalan2').val(jalan);
    $('#kontak_rs2').val(kontak);
    $('#modal-pembeli').modal('hide')
    alertCustom('S','Berhasil Dipilih !','');
  }

  async function modalPembeli() {
    $('#modal-pembeli').modal('show');
    loading_jual();
    await $.get("data/modal-pembeli-all.php",
      function(data) {
        $('#modal-data-pembeli').html(data)
      }
    );
  }
</script>