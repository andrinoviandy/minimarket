<?php
if (isset($_GET['id_hapus'])) {
  //$sel = mysqli_fetch_array(mysqli_query($koneksi, "select barang_dikirim_id from barang_kembali where id=".$_GET['id_hapus'].""));
  $del = mysqli_query($koneksi, "delete from barang_kembali_detail where barang_kembali_id=" . $_GET['id_hapus'] . "");
  $del2 = mysqli_query($koneksi, "delete from barang_kembali where id=" . $_GET['id_hapus'] . "");
  if ($del and $del2) {
    //mysqli_query($koneksi, "update barang_dikirim set status_barang_kembali=0 where id=".$sel['barang_dikirim_id']."");
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
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Data Alkes Rusak Yang Dikembalikan</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Data Alkes Rusak</li>
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

              <a href="index.php?page=tambah_retur">
                <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Retur</button></a>
              <div class="pull pull-right" style="margin-left: 30px;">
                <?php //include "include/getFilter.php"; 
                ?>
                <?php include "include/atur_halaman.php"; ?>
              </div>
              <span class="pull pull-right">
                <table>
                  <tr>
                    <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                    <td valign="top">1. </td>
                    <td valign="top">Tanda &quot;<span class="fa fa-user"></span>&quot; menandakan sudah diberikan <strong>Teknisi</strong></td>
                  </tr>
                </table>
              </span>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
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