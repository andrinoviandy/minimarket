<?php

if (isset($_GET['id_hapus'])) {
  //$del0 = mysqli_query($koneksi, "delete from barang_teknisi_detail_teknisi where id=".$_GET['id_brg_teknisi']."");
  //$update = mysqli_query($koneksi, "update barang_teknisi_detail set status_teknisi=0 where id=".$_GET['id_brg_teknisi']."");
  $del1 = mysqli_query($koneksi, "delete from kasbon_perjalanan_dinas_detail where kasbon_perjalanan_dinas_id=" . $_GET['id_hapus'] . "");
  $del = mysqli_query($koneksi, "delete from kasbon_perjalanan_dinas where id=" . $_GET['id_hapus'] . "");
  if ($del and $del1) {
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
      Kasbon Perjalanan Dinas
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kasbon Perjalanan Dinas</li>
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
          <a href="?page=tambah_kasbon_perjalanan_dinas"><button class="btn btn-success pull pull-left"><span class="fa fa-plus"></span> Tambah </button></a>

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

<script>
  function hapus(id, id_b_t) {
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
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id + '&id_brg_teknisi=' + id_b_t;
      }
    })
  }
</script>