<?php
if (isset($_GET['id_batal'])) {
  $sql = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang_set.id as id_up from barang_dijual_set,utang_piutang_set where barang_dijual_set.no_faktur_jual = utang_piutang_set.no_faktur_no_po_set and barang_dijual_set.id=" . $_GET['id_batal'] . ""));
  //while ($da = mysqli_fetch_array($sql)) {
  //$update=mysqli_query($koneksi, "update barang_gudang_set_2 set qty=qty+$da[qty_jual] where id=".$da['barang_gudang_set2_id']."");
  //}
  $sql2 = mysqli_num_rows(mysqli_query($koneksi, "select * from utang_piutang_set_bayar where utang_piutang_set_id = " . $sql['id_up'] . ""));
  if ($sql2 != 0) {
    echo "<script type='text/javascript'>alert('Maaf Sudah Ada Transaksi Pembayaran !');
		history.back();
		</script>";
  } else {
    $del0 = mysqli_query($koneksi, "delete from utang_piutang_set where id = " . $sql['id_up'] . "");
    $del1 = mysqli_query($koneksi, "delete from barang_dijual_qty_set,barang_dijual_qty_set_detail where barang_dijual_qty_set.id = barang_dijual_qty_set_detail.barang_dijual_qty_set_id and barang_dijual_set_id=" . $_GET['id_batal'] . "");
    $del2 = mysqli_query($koneksi, "delete from barang_dijual_set where id=" . $_GET['id_batal'] . "");

    if ($del1 and $del2) {
      echo "<script>window.location='index.php?page=penjualan_barang_set;</script>";
    } else {
      echo "<script type='text/javascript'>alert('Maaf Data Tidak Dapat DI Hapus !');
		history.back();
		</script>";
    }
  }
  /*$se = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_detail where status_kirim=1 and barang_dijual_id=".$_GET['id_batal'].""));
	if ($se!=0) {
		echo "<script>alert('Data tidak dapat dibatalkan karena sudah dikirim ! Silakan batalkan proses kirim terlebih dahulu !');
		window.location='index.php?page=jual_barang';
		</script>";
		}
	else {
		$sd = mysqli_query($koneksi, "select * from barang_dijual_detail where status_kirim=0 and barang_dijual_id=".$_GET['id_batal']."");
		while ($da = mysqli_fetch_array($sd)) {
			$upp=mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set stok_total=stok_total+1, status_terjual=0 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=".$da['barang_gudang_detail_id']."");
			}
		if ($upp) {
			mysqli_query($koneksi, "delete from barang_dijual_detail where barang_dijual_id=".$_GET['id_batal']."");
			mysqli_query($koneksi, "delete from barang_dijual where id=".$_GET['id_batal']."");
			echo "<script>alert('Pembatalan berhasil !');
		window.location='index.php?page=jual_barang';
		</script>";
			}
			else {
				echo "<script>alert('Pembatalan Gagal !');
		window.location='index.php?page=jual_barang';
		</script>";
				}
		}*/
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Penjualan Barang Set
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Jual Alkes</li>
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
          <span class="pull pull-left">
            <?php if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_admin_gudang'])) { ?>
              <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
                <a href="index.php?page=penjualan_barang_set#openPilihan">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
              </div>
            <?php } ?>
          </span>
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
        <div class="box box-info">
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
if (isset($_POST['kirim_barang'])) {
  mysqli_query($koneksi, "delete from barang_dikirim_detail_set_hash where akun_id=" . $_SESSION['id'] . "");
  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_peng'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['no_po'] = $_POST['no_po'];
  echo "<script type='text/javascript'>
		window.location='index.php?page=simpan_kirim_barang_set&id=" . $_GET['id'] . "';
		</script>";
}
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
    <h3 align="center">Kirim Alkes</h3>
    <form method="post">
      <!--<label>Pilih Alkes</label>
     <select id="input" name="id_alkes" required>
     	<?php
        $q3 = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang,barang_gudang_detail where barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and status_kirim=0 and barang_dijual_id=" . $_GET['id'] . "");
        $q4 = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang,barang_gudang_detail where barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and status_kirim=1 and barang_dijual_id=" . $_GET['id'] . "");
        $q5 = mysqli_query($koneksi, "select * from barang_dijual_set where id=" . $_GET['id'] . "");
        $d4 = mysqli_num_rows($q4);
        if ($d4 == 0) {
        ?>
        <option value="all">All</option>
        <?php } ?>
        <?php
        while ($d3 = mysqli_fetch_array($q3)) { ?>
		<option value="<?php echo $d3['idd']; ?>"><?php echo $d3['nama_brg'] . " - No Seri : " . $d3['no_seri_brg']; ?></option>
		<?php } ?>
     </select>
     -->
      <label>Nama Paket</label>
      <input id="input" type="text" placeholder="" name="nama_paket" required>
      <label>No. Pengiriman</label>
      <input id="input" type="text" placeholder="" name="no_peng" required>
      <label>Tanggal Pengiriman</label>
      <input id="input" type="date" placeholder="" name="tgl_kirim" required>
      <label>No. Faktur</label>
      <input id="input" type="text" placeholder="" readonly="readonly" name="no_po" value="<?php
                                                                                            $d5 = mysqli_fetch_array($q5);
                                                                                            echo $d5['no_faktur_jual'];
                                                                                            ?>">

      <button id="buttonn" name="kirim_barang" type="submit">Next</button>
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
      <br />
      <br />
    </form>
  </div>
</div>

<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=jual_barang_set"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=jual_barang_set2"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
  </div>
</div>