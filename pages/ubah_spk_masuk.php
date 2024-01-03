<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_teknisi where id = ".$_GET['id'].""));
if (isset($_POST['tambah_spk_masuk'])) {
    $q = mysqli_query($koneksi, "update barang_teknisi set tgl_spk='".$_POST['tgl_spk']."', no_spk='".$_POST['no_spk']."', keterangan_spk='".$_POST['keterangan']."' where id=".$_GET['id']."");
    if ($q) {    
      echo "<script type='text/javascript'>
      window.location='index.php?page=spi';
      </script>";
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah SPI
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="index.php?page=barang_masuk">Surat Perintah Instalasi</a></li>
        <li class="active">Ubah</li></ol></section>


    <!-- Main content -->
    <section class="content">
    
      <!-- Small boxes (Stat box) --><!-- /.row -->
      <!-- Main row -->
      <form id="frm-mhs" name="example_form" action="" method="POST" data-validate="parsley" enctype="multipart/form-data" >
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success"><!-- /.chat -->
            <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Tanggal SPI</h3>
            </div>
              <div class="box-body">
              <input name="tgl_spk" type="date" class="form-control" autofocus="autofocus" required="required" <?php echo $dis; ?> value="<?php echo $data['tgl_spk'] ?>"/>                                  
              </div>
            <div class="box-header with-border">
              <h3 class="box-title">No SPI</h3>
            </div>
              <div class="box-body">
              <input name="no_spk" type="text" class="form-control" required="required" <?php echo $dis; ?> value="<?php echo $data['no_spk'] ?>"/>
              
              </div>
              <div class="box-header with-border">
              <h3 class="box-title">Deskripsi</h3>
            </div>
              <div class="box-body">
              <textarea class="form-control" rows="4" name="keterangan"><?php echo $data['keterangan_spk'] ?></textarea>
              <br />
              <button name="tambah_spk_masuk" type="submit" class="btn btn-success" style="padding:8px"><span class="fa fa-check"></span> Simpan </button>
              
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
          <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

          <!-- Chat box --><!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
        
        <section class="col-lg-12 connectedSortable" align="center">
          
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
      </form>
    <script type="text/javascript">    
	<?php 
	echo $jsArray; 
	?>  
	function changeValue(id_barang){  
		
		document.getElementById('pembeli').value = dtBrg[id_barang].nama_pembeli;
		document.getElementById('provinsi').value = dtBrg[id_barang].provinsi;
		document.getElementById('kabupaten').value = dtBrg[id_barang].kabupaten;
		document.getElementById('kecamatan').value = dtBrg[id_barang].kecamatan;
		document.getElementById('kelurahan').value = dtBrg[id_barang].kelurahan;
		document.getElementById('jalan').value = dtBrg[id_barang].jalan;
		document.getElementById('kontak_rs').value = dtBrg[id_barang].kontak_rs;
		document.getElementById('nama_pemakai').value = dtBrg[id_barang].nama_pemakai;
		document.getElementById('kontak1').value = dtBrg[id_barang].kontak1;
		document.getElementById('kontak2').value = dtBrg[id_barang].kontak2;
		document.getElementById('email').value = dtBrg[id_barang].email;
	};  
</script>
      <!-- /.row (main row) -->

  </section>
    <!-- /.content -->
  </div>
  
  <div id="tambahTeknisi" class="modalDialog">
     <div>
        <a href="#" title="Close" class="close">X</a>
        <h3 align="center">Tambah Teknisi Baru</h3> 
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
              <input name="sertifikat" id="input" type="file" style="background-color:#FFF"/><br />
        <button id="buttonn" name="tambahteknisibaru" type="submit">Simpan</button>
    </form>
    
    </div>
</div>
  