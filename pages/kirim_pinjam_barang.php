<?php
if (isset($_POST['pencarian'])) {
  if ($_POST['pilihan'] == 'tgl_kirim') {
    echo "<script>window.location='index.php?page=kirim_pinjam_barang&pilihan=$_POST[pilihan]&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&tampil=$_POST[tampil]'</script>";
  } elseif ($_POST['pilihan'] == 'tgl_sampai') {
    echo "<script>window.location='index.php?page=kirim_pinjam_barang&pilihan=$_POST[pilihan]&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&tampil=$_POST[tampil]'</script>";
  } else {
    echo "<script>window.location='index.php?page=kirim_pinjam_barang&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]&tampil=$_POST[tampil]'</script>";
  }
}

if (isset($_GET['id_b_s'])) {
  $q = mysqli_query($koneksi, "update barang_pinjam_kirim set tgl_sampai='' where id=" . $_GET['id_b_s'] . "");
  if ($q) {
    echo "<script>window.location='index.php?page=kirim_barang_pinjam'</script>";
  }
}
if (isset($_GET['id_hapus'])) {
  $sel = mysqli_query($koneksi, "update barang_pinjam_kirim_detail,barang_pinjam_detail set barang_pinjam_detail.status_kirim=0 where barang_pinjam_detail.barang_gudang_detail_id and barang_pinjam_kirim_detail.barang_gudang_detail_id and barang_pinjam_kirim_id=" . $_GET['id_hapus'] . "");

  if ($sel) {
    $del1 = mysqli_query($koneksi, "delete from barang_pinjam_kirim_detail where barang_pinjam_kirim_id=" . $_GET['id_hapus'] . "");
    $del2 = mysqli_query($koneksi, "delete from barang_pinjam_kirim where id=" . $_GET['id_hapus'] . "");
    echo "<script>
            Swal.fire({
              customClass: {
                confirmButton: 'bg-green',
                cancelButton: 'bg-white',
              },
              title: 'Data Berhasil Dihapus',
              icon: 'success',
              confirmButtonText: 'OK',
            })
            </script>";
  } else {
    echo "<script>
            Swal.fire({
              customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
              },
              title: 'Data Gagal Dihapus',
              icon: 'error',
              confirmButtonText: 'OK',
            })
            </script>";
  }

  //$q2 = mysqli_query($koneksi, "select * from barang_dikirim,barang_dikirm_detail,barang_gudang_detail,barang_gudang where barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim.id=".$_GET['id_hapus']."");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengiriman Barang Pinjaman
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kirim Barang Pinjaman</li>
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
          <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
            
          </div>

          <!--<form method="post" action="cetak_stok_alkes.php">-->

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
        <div class="box box-warning">
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
if (isset($_POST['sampai_barang'])) {
  $tgl_k = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pinjam_kirim where id=" . $_GET['id'] . ""));
  if ($_POST['tgl_sampai'] >= $tgl_k['tgl_kirim']) {
    $que = mysqli_query($koneksi, "update barang_pinjam_kirim set tgl_sampai='" . $_POST['tgl_sampai'] . "' where id=" . $_GET['id'] . "");
    if ($que) {
      //mysqli_query($koneksi, "insert into uji_f_i values('','".$_GET['id']."','0','0','')");
      echo "<script type='text/javascript'>
		  window.location='index.php?page=kirim_barang_pinjam'
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
    <?php $d = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_pinjam_kirim where id=" . $_GET['id'] . "")); ?>
    <form method="post">
      <label>Tanggal Sampai</label>
      <input id="input" type="date" placeholder="" name="tgl_sampai" required value="<?php echo $d['tgl_sampai']; ?>">

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

<script>
  
  function hapus(id_hapus) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Data AKan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id_hapus;
      }
    })
  }
</script>