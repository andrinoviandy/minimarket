<?php
if (isset($_GET['simpan_barang']) == 1) {
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . ""));
  if ($cek != 0) {
    //$insert_pembeli=mysqli_query($koneksi, "insert into pembeli values('','".$_SESSION['pembeli']."','".$_SESSION['provinsi']."','".$_SESSION['kabupaten']."','".$_SESSION['kecamatan']."','".$_SESSION['kelurahan']."','".$_SESSION['alamat']."','".$_SESSION['kontak_rs']."')");

    //$insert_pemakai=mysqli_query($koneksi, "insert into pemakai values('','".$_SESSION['pemakai']."','".$_SESSION['kontak1']."','".$_SESSION['kontak2']."','".$_SESSION['email']."')");

    //$pembeli=mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pembeli from pembeli"));
    /*$id_pembeli=$_SESSION['pembeli'];
	$pemakai=mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pemakai from pemakai"));
	$id_pemakai=$pemakai['id_pemakai'];
	//simpan barang dijual
	$total = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash where akun_id=".$_SESSION['id'].""));
	*/
    $simpan1 = mysqli_query($koneksi, "insert into barang_teknisi values('','" . $_SESSION['tgl_spi'] . "','" . $_SESSION['no_spi'] . "','" . $_SESSION['keterangan'] . "')");

    $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from barang_teknisi"));
    $id_jual = $d1['id_max'];
    //simpan barang pesan detail
    $q2 = mysqli_query($koneksi, "select * from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . "");
    while ($d2 = mysqli_fetch_array($q2)) {
      $simpan2 = mysqli_query($koneksi, "insert into barang_teknisi_detail values('','$id_jual','" . $d2['barang_dikirim_detail_id'] . "','0','0')");
      $up = mysqli_query($koneksi, "update barang_dikirim_detail set status_spi=1 where id=" . $d2['barang_dikirim_detail_id'] . "");
      //$up2=mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=".$d2['barang_gudang_detail_id']."");
    }
    if ($simpan1 and $simpan2) {
      mysqli_query($koneksi, "delete from barang_teknisi_hash where akun_id=" . $_SESSION['id'] . "");
      echo "<script type='text/javascript'>
	alert('Data Berhasil Di Simpan !');
	window.location='index.php?page=spi'</script>";
    }
  } else {
    echo "<script type='text/javascript'>
	alert('Data tidak boleh kosong , silakan tambah terlebih dahulu ! !');
	window.location='index.php?page=tambah_spk_masuk2'</script>";
  }
}


if (isset($_POST['simpan_tambah_aksesoris'])) {
  //$no=mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash"))+1;
  
}

if (isset($_POST['go_no_seri'])) {
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select *,barang_dikirim_detail.id as idd from barang_dikirim_detail, barang_dikirim,barang_gudang,barang_gudang_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.status_spi=0 and barang_dikirim.id=" . $_POST['id_akse'] . ""));
  if ($cek != 0) {
    echo "<script>
alert('Selanjutnya Silakan Tekan (Pilih No Seri) !');	window.location='index.php?page=tambah_spk_masuk2&id_gudang=$_POST[id_akse]';
	</script>";
  } else {
    echo "<script>
	alert('Data Sudah Ada !);
	window.location='index.php?page=tambah_spk_masuk2';
	</script>";
  }
}

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah SPI</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Tambah SPI</li>
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
            <div class="box-body">
              <div class="">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered">
                    <thead>
                      <tr height="">
                        <th width="11%" valign="bottom"><strong>Tgl SPI</strong></th>
                        <th width="23%" valign="bottom">No SPI</th>
                        <th width="66%" valign="bottom">Deskripsi</th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php echo date("d F Y", strtotime($_SESSION['tgl_spi'])); ?>
                      </td>
                      <td><?php echo $_SESSION['no_spi']; ?></td>
                      <td><?php echo $_SESSION['keterangan']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />

                <?php if (isset($_GET['id_gudang'])) { ?>
                  <button name="tambah_laporan2" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-pilihnoseri2"><span class="fa fa-plus"></span> Pilih No Seri </button>
                  &nbsp;&nbsp;
                  <button name="tambah_laporan" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-pilihnoseri"><span class="fa fa-plus"></span> Ulangi Dengan No. PO dan No. Pengiriman Yang Lain</button>
                <?php } else { ?>
                  <!-- <button name="tambah_laporan" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-pilihnoseri"> -->
                  <button class="btn btn-success" type="button" onclick="modalTambah(); return false;">
                    <span class="fa fa-plus"></span> Tambah
                  </button>
                <?php } ?>
                <font color="#FF0000" class="pull pull-right" size="+2">* Gunakan No PO Yang Sama Jika Data Lebih Dari Satu</font><br /><br />
                <div id="barang-spi"></div>
                <center><a href="index.php?page=tambah_spk_masuk2&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button></a>&nbsp;&nbsp;<a href="index.php?page=spi"><button name="batal" class="btn btn-success" type="submit"><span class="fa  fa-times-circle"></span> Batal</button></a></center>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
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
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<?php
if (isset($_POST['tambah_laporan'])) {
  $Result = mysqli_query($koneksi, "insert into aksesoris values('','" . $_POST['nama_akse'] . "','" . $_POST['merk'] . "','" . $_POST['tipe'] . "','" . $_POST['no_seri'] . "','" . $_POST['stok'] . "', '" . $_POST['deskripsi'] . "','" . $_POST['harga_satuan'] . "')");
  if ($Result) {
    echo "<script type='text/javascript'>
		alert('Data Berhasil Di Tambah !');
		window.location='index.php?page=simpan_tambah_aksesoris&id=$_GET[id]';
		</script>";
  }
}
?>


<div class="modal fade" id="modal-pilihnoseri">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Tambah Data</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanData(); return false;" id="form-spi">
        <div class="modal-body">
          <div id="modal-spi"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="go_no_seri">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-pilihnoseri2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Pilih Barang</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <label>Pilih Alkes / No Seri</label>
          <select name="no_seri" id="no_seri" class="form-control select2" style="width:100%">
            <option value="">--Semua nya--</option>
            <?php
            $q_seri = mysqli_query($koneksi, "select *,barang_dikirim_detail.id as idd from barang_dikirim_detail, barang_dikirim,barang_gudang,barang_gudang_detail where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.status_spi=0 and barang_dikirim.id=" . $_GET['id_gudang'] . "");
            while ($d_seri = mysqli_fetch_array($q_seri)) {
            ?>
              <option id="id_kirim_detail" value="<?php echo $d_seri['idd']; ?>">
                <?php echo $d_seri['nama_brg'] . " / " . $d_seri['no_seri_brg']; ?></option>
            <?php } ?>
          </select>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="simpan_tambah_aksesoris">Simpan</button>
        </div>
      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</div>

<script>
  function getDataSpi() {
    loading2('#barang-spi')
    $.get("data/barang-spi.php",
      function(data, textStatus, jqXHR) {
        $('#barang-spi').html(data);
      }
    );
  }

  function modalTambah() {
    $('#modal-pilihnoseri').modal('show');
    loading2("#modal-spi");
    $.get("data/modal-spi.php",
      function(data, textStatus, jqXHR) {
        $('#modal-spi').html(data);
      }
    );
  }

  function metodePilih() {
    var check1 = $('#manual').prop('checked');
    var check2 = $('#semua').prop('checked');
    if (check1 === true) {
      $('#no_seri').prop('disabled', false);
      $('#no_seri').prop('placeholder', 'Silakan Pilih No Seri');
    }
    if (check2 === true) {
      $('#no_seri').prop('disabled', true);
      $('#no_seri').val([]);
      $('#no_seri').trigger('change.select2');
    }
  }

  function simpanData() {
    showLoading(1)
    var check2 = $('#semua').prop('checked');
    $.post("data/simpan-tambah-spi.php", {
      id: <?php echo $_SESSION['id'] ?>,
      id_kirim: $('#id_akse').val(),
      metode: check2 === true ? 'all' : '',
      no_seri: $('#no_seri').val(),
    },
    function (data, textStatus, jqXHR) {
        showLoading(0)
        if (data === 'S') {
          $('#modal-pilihnoseri').modal('hide');
          alertCustom('S', 'Sukses !', 'Data Berhasil Disimpan !')
        } else if (data === 'KOSONG') {
          alertCustom('F', 'Gagal !', 'Data No Seri Tidak Boleh Jika Metode Yang Dipilih Tidak Semua')
        } else if (data === 'BEDA_PO') {
          alertCustom('F', 'Gagal !', 'Maaf 1 SPI Hanya Dapat Menampung 1 PO Saja')
        } else {
          alertCustom('F', 'Gagal !', 'Data Gagal Disimpan')
        }
        getDataSpi()
      }
    );
  }

  function hapusData(value) {
    $.post("data/hapus-tambah-spi.php", {id_hapus: value},
      function (data, textStatus, jqXHR) {
        if (data === 'S') {
          alertHapus('S')
        } else {
          alertHapus('F')
        }
        getDataSpi()
      }
    );
  }

  $(document).ready(function() {
    getDataSpi()
  });
</script>