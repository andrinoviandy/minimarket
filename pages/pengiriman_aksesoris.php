<?php
if (isset($_POST['sampai_barang'])) {
  $tgl_k = mysqli_fetch_array(mysqli_query($koneksi, "select * from aksesoris_kirim where id=" . $_POST['id_tgl'] . ""));
  if ($_POST['tgl_sampai'] >= $tgl_k['tgl_kirim_akse']) {
    $que = mysqli_query($koneksi, "update aksesoris_kirim set tgl_sampai_akse='" . $_POST['tgl_sampai'] . "' where id=" . $_GET['id'] . "");
    if ($que) {
      //mysqli_query($koneksi, "insert into uji_f_i values('','".$_GET['id']."','0','0','')");
      echo "<script type='text/javascript'>
		  window.location='index.php?page=pengiriman_aksesoris'
		  </script>";
    }
  } else {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-yellow',
        cancelButton: 'bg-white',
      },
      title: 'Tanggal Sampai Tidak Boleh Kurang Dari Tanggal Pengiriman',
      icon: 'warning',
      confirmButtonText: 'OK',
    })
    </script>";
  }
}

if (isset($_GET['id_b_s'])) {
  $q = mysqli_query($koneksi, "update aksesoris_kirim set tgl_sampai_akse='' where id=" . $_GET['id_b_s'] . "");
  if ($q) {
    echo "<script>window.location='index.php?page=pengiriman_aksesoris'</script>";
  }
}

if (isset($_GET['id_hapus'])) {
  $sel = mysqli_query($koneksi, "select * from aksesoris_kirim_detail where aksesoris_kirim_id=" . $_GET['id_hapus'] . "");
  while ($da = mysqli_fetch_array($sel)) {
    mysqli_query($koneksi, "update aksesoris_detail set status_kirim_akse=0 where id=" . $da['aksesoris_detail_id'] . "");
  }
  $jml_sel = mysqli_num_rows(mysqli_query($koneksi, "select * from aksesoris_kirim_detail where aksesoris_kirim_id=" . $_GET['id_hapus'] . ""));
  $up = mysqli_query($koneksi, "update aksesoris,aksesoris_detail,aksesoris_kirim_detail set stok_total_akse=stok_total_akse+$jml_sel where aksesoris.id=aksesoris_detail.aksesoris_id and aksesoris_detail.id=aksesoris_kirim_detail.aksesoris_detail_id and aksesoris_kirim_id=" . $_GET['id_hapus'] . "");
  $hapus = mysqli_query($koneksi, "delete from aksesoris_kirim_detail where aksesoris_kirim_id=" . $_GET['id_hapus'] . "");
  $hapus2 = mysqli_query($koneksi, "delete from aksesoris_kirim where id=" . $_GET['id_hapus'] . "");
  if ($hapus and $hapus2) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Dihapus ',
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
      title: 'Data Gagal Dihapus ',
      icon: 'error',
      confirmButtonText: 'OK',
    })
    </script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengiriman Aksesoris
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kirim Aksesoris</li>
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
                <div class="pull pull-right">
                  <?php include "include/getFilter.php"; ?>
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

<!-- <div id="openSampai" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Status Pengiriman Aksesoris</h3>
    <?php //$d = mysqli_fetch_array(mysqli_query($koneksi, "select * from aksesoris_kirim where id=" . $_GET['id'] . "")); ?>
    <form method="post">
      <label>Tanggal Sampai</label>
      <input id="input" type="date" placeholder="" name="tgl_sampai" required value="<?php echo $d['tgl_sampai_akse']; ?>">
      <!--<label>Keterangan</label>
     <textarea rows="4" id="input" type="text" placeholder="Keterangan" name="keterangan"><?php echo $d['ket_brg']; ?></textarea>-->
      <!-- <button id="buttonn" name="sampai_barang" type="submit">Simpan</button>
    </form>
  </div>
</div> -->
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

<div class="modal fade" id="modal-masuk-gudang">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tanggal Sampai</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <input type="hidden" name="id_tgl" id="id_tgl" />
          <input class="form-control" id="tgl_lunas" type="date" name="tgl_sampai">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="sampai_barang" type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function hapus(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id;
      }
    })
  }

  function belumSampai(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Membatalkan Tanggal Sampai ?',
      text: 'Tanggal Sampai Akan Kembali Kosong',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Batalkan',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_b_s=' + id;
      }
    })
  }

  function sudahSampai(id, tgl) {
    document.getElementById("id_tgl").value = id;
    document.getElementById("tgl_lunas").value = tgl;
    $('#modal-masuk-gudang').modal('show');
  }
</script>