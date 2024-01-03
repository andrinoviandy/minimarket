<?php
if (isset($_GET['id_hapus'])) {
  //$sel = mysqli_fetch_array(mysqli_query($koneksi, "select barang_dikirim_id from barang_kembali_tidak_rusak where id=".$_GET['id_hapus'].""));
  $sel = mysqli_query($koneksi, "select * from barang_kembali_tidak_rusak,barang_kembali_tidak_rusak_detail where barang_kembali_tidak_rusak.id=barang_kembali_tidak_rusak_detail.barang_kembali_tidak_rusak_id and barang_kembali_tidak_rusak.id=" . $_GET['id_hapus'] . "");
  while ($up = mysqli_fetch_array($sel)) {
    $update = mysqli_query($koneksi, "update barang_gudang_detail,barang_dikirim_detail set status_kirim=1, status_kerusakan=0, status_kembali_ke_gudang=0,status_batal=0 where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_id=" . $up['barang_dikirim_id'] . "");
    $update2 = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $up['barang_gudang_detail_id'] . "");
  }
  $del = mysqli_query($koneksi, "delete from barang_kembali_tidak_rusak_detail where barang_kembali_tidak_rusak_id=" . $_GET['id_hapus'] . "");
  $del2 = mysqli_query($koneksi, "delete from barang_kembali_tidak_rusak where id=" . $_GET['id_hapus'] . "");
  if ($update and $update2 and $del and $del2) {
    //mysqli_query($koneksi, "update barang_dikirim set status_barang_kembali_tidak_rusak=0 where id=".$sel['barang_dikirim_id']."");
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
      Pengembalian Alkes (Tidak Rusak)</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Alkes</li>
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
            <a href="index.php?page=tambah_retur_tidak_rusak">
              <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Retur</button>
            </a>
          </div>

          <!--<form method="post" action="cetak_stok_alkes.php">-->

          <div class="pull pull-right">
            <?php //include "include/getFilter.php"; 
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
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->

      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>

<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=jual_barang2&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Data Dinas/RS/Puskesmas/Klinik Baru</button></a>
    <a href="index.php?page=jual_barang3&id=<?php echo $_GET['id']; ?>"><button id="buttonn">Dari Data Dinas/RS/Puskesmas/Klinik<br />Yang Sudah Terinput</button></a>
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
      text: 'Data Akan Dihapus Secara Permanen',
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