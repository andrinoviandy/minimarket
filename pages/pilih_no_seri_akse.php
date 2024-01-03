<?php 
if (isset($_GET['simpan_barang'])==1) {
	$s1=mysqli_query($koneksi, "insert into aksesoris_kirim values('','".$_SESSION['nama_paket']."','".$_SESSION['no_pengiriman']."','".$_SESSION['tgl_pengiriman']."','".$_SESSION['no_po']."','')");
	$max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from aksesoris_kirim"));
	$q = mysqli_query($koneksi, "select * from aksesoris_kirim_detail_hash where akun_id=".$_SESSION['id']."");
	while ($d = mysqli_fetch_array($q)) {
		$s = mysqli_query($koneksi, "insert into aksesoris_kirim_detail values('','".$max['id_max']."','".$d['aksesoris_jual_qty_id']."','".$d['aksesoris_detail_id']."')");
		$up_stok = mysqli_query($koneksi, "update aksesoris,aksesoris_detail set stok_total_akse=stok_total_akse-1 where aksesoris.id=aksesoris_detail.aksesoris_id and aksesoris_detail.id=".$d['aksesoris_detail_id']."");
		$up_status = mysqli_query($koneksi, "update aksesoris_detail set status_kirim_akse=1 where id=".$d['aksesoris_detail_id']."");
		}
	if ($s1 and $s and $up_status and $up_stok) {
		mysqli_query($koneksi, "delete from aksesoris_kirim_detail_hash where akun_id=".$_SESSION['id']."");
		echo "<script>
		alert('Berhasil disimpan !');
		window.location='index.php?page=pengiriman_aksesoris'</script>";
		}
}


if (isset($_POST['simpan_tambah_aksesoris'])) {
	//$no=mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash"))+1;
	/*$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang,barang_gudang_detail,barang_dijual_detail,barang_dijual where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_dijual.id=barang_dijual_detail.barang_dijual_id and barang_dijual.id=".$_GET['id']." and barang_gudang.id=".$_POST['id_akse'].""));
	$cek2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual_qty,barang_gudang where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=".$_GET['id']." and barang_gudang.id=".$_POST['id_akse'].""));
	
	if ($cek>$cek2['qty_jual']) {
		echo "<script>
		alert('Maaf jumlah dengan alkes ini sudah terpenuhi !');
		window.location='index.php?page=pilih_no_seri&id=$_GET[id]'</script>";
		}
	else {*/
	//mysqli_query($koneksi, "");
	$cek=mysqli_fetch_array(mysqli_query($koneksi, "select qty_jual_akse from aksesoris_jual_qty where id=".$_POST['id_qty'].""));
	$cek2=mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail where aksesoris_jual_qty_id=".$_POST['id_qty'].""));
	$cek3=mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail_hash where aksesoris_jual_qty_id=".$_POST['id_qty'].""));
	$nil1 = $cek['qty_jual_akse']-$cek2;
	if ($nil1>$cek3) {
	$simpan = mysqli_query($koneksi, "insert into aksesoris_kirim_detail_hash values('','".$_SESSION['id']."','".$_POST['id_qty']."','".$_POST['no_seri']."')");
	if ($simpan) {
		echo "<script>window.location='index.php?page=pilih_no_seri_akse&id=$_GET[id]'</script>";
			}
	}
	else {
		echo "<script>
		alert('Gagal ! Sudah Mencukupi Kuantitas');
		window.location='index.php?page=pilih_no_seri_akse&id=$_GET[id]'</script>";
		}
		//}
	}
	
if (isset($_GET['id_hapus'])) {
	$del = mysqli_query($koneksi, "delete from aksesoris_kirim_detail_hash where id=".$_GET['id_hapus']."");
	}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Jual Aksesoris</h1><ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Jual Aksesoris</li>
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
              <table width="100%" id="" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th valign="bottom"><strong>Nama Paket</strong></th>
      <td align="center" valign="bottom"><strong>No. Pengiriman</strong></td>
      <td align="center" valign="bottom"><strong>Tanggal Pengiriman</strong></td>
      <td align="center" valign="bottom"><strong>No. Faktur      
      </strong></td>
     </tr>
    <tr>
      <th valign="bottom"><?php echo $_SESSION['nama_paket']; ?></th>
      <td align="center" valign="bottom"><?php echo $_SESSION['no_pengiriman']; ?></td>
      <td align="center" valign="bottom"><?php echo $_SESSION['tgl_pengiriman']; ?></td>
      <td align="center" valign="bottom"><?php echo $_SESSION['no_po']; ?></td>
      </tr>
  </thead>
  
  <script type="text/javascript">    
	<?php 
	echo $jsArray; 
	?>  
	function changeValue(id_akse){  
		document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse; 
		document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
		document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
		document.getElementById('harga').value = dtBrg[id_akse].harga;
	};  
</script>
  <?php
   
  $no=0;
  $q_akse = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang_detail,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_dijual_detail.barang_dijual_id=".$_GET['id']."");
  $jm = mysqli_num_rows($q_akse);
  if ($jm!=0) { 
  while ($data_akse = mysqli_fetch_array($q_akse)) {
	  $no++;
  ?>
  <?php }} ?>
</table>
              <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
              <br /><br />
              <font class="" size="+2">
                  Pilih No Seri Atau Nama Set Yang Akan Dijual</font><br /><font class="" color="#FF0000"><?php 
				  $qty = mysqli_query($koneksi, "select *,aksesoris_jual_qty.id as id_qty from aksesoris_jual_qty,aksesoris where aksesoris.id=aksesoris_jual_qty.aksesoris_id and aksesoris_jual_id=".$_GET['id']."");
				  while ($d_qty = mysqli_fetch_array($qty)) {
					  $sel = mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail where aksesoris_jual_qty_id=".$d_qty['id_qty'].""));
					  echo $d_qty['nama_akse']." (".($d_qty['qty_jual_akse']-$sel).")<br>";
					  }
				  
				  ?></font>
                  <!--<font color="#FF0000">* Jika Ingin Menambah Data Aksesoris Yang Baru ! Klik Disini <a href="index.php?page=simpan_tambah_aksesoris&id=<?php //echo $_GET['id']; ?>#openAkse"><small data-toggle="tooltip" title="Tambah Aksesoris Baru" class="label bg-blue">+ New Accessories</small></a></font>-->
               
                <table width="100%" id="example3" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th valign="bottom">No</th>
      <th valign="bottom"><strong>Nama Aksesoris</strong></th>
      <td align="center" valign="bottom"><strong>
        Harga Jual</strong></td>
      <td align="center" valign="bottom"><strong>Tipe      
      </strong></td>
      <td align="center" valign="bottom"><strong>Merk      
      </strong></td>
      <td align="center" valign="bottom"><strong>NIE      
      </strong></td>
      <td align="center" valign="bottom"><strong>No Seri / Nama Set</strong></td>
      <td align="center" valign="bottom"><strong>Aksi</strong></td>
     </tr>
  </thead>
  <tr>
    <td>#</td>
    <form method="post" name="form1" enctype="multipart/form-data">
    <td>
    <select name="id_akse" id="id_akse" class="form-control" autofocus="autofocus" required onchange="changeValue(this.value)">
    	<option value="">-- Pilih --</option>
        
		<?php 
		$q = mysqli_query($koneksi, "select *,aksesoris.id as idd, aksesoris_jual_qty.id as id_qty from aksesoris,aksesoris_jual,aksesoris_jual_qty where aksesoris.id=aksesoris_jual_qty.aksesoris_id and aksesoris_jual.id=aksesoris_jual_qty.aksesoris_jual_id and aksesoris_jual.id=".$_GET['id']." group by nama_akse order by nama_akse ASC");
		$jsArray = "var dtBrg = new Array();
";
		while ($d = mysqli_fetch_array($q)) { ?>
        <option value="<?php echo $d['idd']; ?>"><?php echo $d['nama_akse']; ?></option>
        <?php 
		$jsArray .= "dtBrg['" . $d['idd'] . "'] = {tipe_akse:'".addslashes($d['tipe_akse'])."',
						merk_akse:'".addslashes($d['merk_akse'])."',
						id_qty:'".addslashes($d['id_qty'])."',
						harga:'".addslashes("Rp ".number_format($d['harga_akse'],2,',','.'))."',
						no_akse:'".addslashes($d['nie_akse'])."'
						};";
		} ?>
    </select>
    </td>
    <td align="center"><strong>
      <input id="id_qty" name="id_qty" class="form-control" type="hidden" placeholder=""/>
    </strong>      <input id="harga" name="harga" class="form-control" type="text" placeholder="Harga" disabled="disabled"/></td>
    <td align="center"><input id="tipe_akse" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled"/></td>
    <td align="center"><input id="merk_akse" name="merk_akse" class="form-control" type="text"  placeholder="Merk" disabled="disabled"/></td>
    <td align="center"><input id="no_akse" name="no_akse" class="form-control" type="text" placeholder="No Akse" disabled="disabled" /></td>
    <td align="center">
    <select name="no_seri" id="no_seri" class="form-control select2" required>
    <option value="">--Pilih--</option>
    <?php
	$q_seri = mysqli_query($koneksi, "select *,aksesoris_detail.id as idd from aksesoris_detail INNER JOIN aksesoris ON aksesoris.id=aksesoris_detail.aksesoris_id and status_kirim_akse=0 order by no_seri_akse ASC");
	while ($d_seri=mysqli_fetch_array($q_seri)) {
	?>
    <option id="no_seri" value="<?php echo $d_seri['idd']; ?>" class="<?php echo $d_seri['aksesoris_id']; ?>"><?php echo $d_seri['no_seri_akse']." ".$d_seri['nama_set_akse']; ?></option>
    <?php } ?>
    </select>
    <script src="jquery-1.10.2.min.js"></script>
        <script src="jquery.chained.min.js"></script>
        <script>
            $("#no_seri").chained("#id_akse");
        </script>
    </td>
    <td align="center"><button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></td>
    </form>
  </tr>
  
  <script type="text/javascript">    
	<?php 
	echo $jsArray; 
	?>  
	function changeValue(id_akse){  
		document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse; 
		document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
		document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
		document.getElementById('harga').value = dtBrg[id_akse].harga;
		document.getElementById('id_qty').value = dtBrg[id_akse].id_qty;
	};  
</script>
  <?php
   
  $no=0;
  $q_akse = mysqli_query($koneksi, "select *,aksesoris_kirim_detail_hash.id as idd from aksesoris_kirim_detail_hash,aksesoris,aksesoris_detail where aksesoris.id=aksesoris_detail.aksesoris_id and aksesoris_detail.id=aksesoris_kirim_detail_hash.aksesoris_detail_id and akun_id=".$_SESSION['id']."");
  
  while ($data_akse = mysqli_fetch_array($q_akse)) {
	  $no++;
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $data_akse['nama_akse']; ?>
    </td>
    <td align="center"><?php echo "Rp ".number_format($data_akse['harga_akse'],0,',','.'); ?></td>
    <td align="center"><?php echo $data_akse['tipe_akse']; ?></td>
    <td align="center"><?php echo $data_akse['merk_akse']; ?></td>
    <td align="center"><?php echo $data_akse['nie_akse']; ?></td>
    <td align="center"><?php echo $data_akse['no_seri_akse']." ".$data_akse['nama_set_akse']; ?></td>
    <td align="center"><a href="index.php?page=pilih_no_seri_akse&id=<?php echo $_GET['id']; ?>&id_hapus=<?php echo $data_akse['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"><span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span></a></td>
    </tr>
  <?php } ?>
</table>
<center><a href="index.php?page=pilih_no_seri_akse&id=<?php echo $_GET['id']; ?>&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button></a></center>
<!--
<center><a href="index.php?page=simpan_jual_alkes2&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button></a>&nbsp;&nbsp;<a href="index.php?page=jual_barang"><button name="batal" class="btn btn-success" type="submit"><span class="fa  fa-times-circle"></span> Batal</button></a></center>
-->
</div>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
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
	$Result = mysqli_query($koneksi, "insert into aksesoris values('','".$_POST['nama_akse']."','".$_POST['merk']."','".$_POST['tipe']."','".$_POST['no_seri']."','".$_POST['stok']."', '".$_POST['deskripsi']."','".$_POST['harga_satuan']."')");
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
