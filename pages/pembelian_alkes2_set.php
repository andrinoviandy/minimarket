<?php
if (isset($_GET['id_hapus'])) {
  $sel = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_pesan from barang_pesan_set where id=" . $_GET['id_hapus'] . ""));
  $del0 = mysqli_query($koneksi, "delete from utang_piutang where no_faktur_no_po='" . $sel['no_po_pesan'] . "'");
  $del2 = mysqli_query($koneksi, "delete from barang_pesan_detail_set where barang_pesan_set_id=" . $_GET['id_hapus'] . "");
  $del = mysqli_query($koneksi, "delete from barang_pesan_set where id=" . $_GET['id_hapus'] . "");
  if ($del0 and $del and $del2) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data berhasil di hapus ',
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
      title: 'Data Gagal di hapus ',
      icon: 'error',
      confirmButtonText: 'OK',
    })
		</script>";
  }
}

if (isset($_GET['id_pulih'])) {
  $up = mysqli_query($koneksi, "update barang_pesan_set set status_po_batal=0,deskripsi_batal='' where id=" . $_GET['id_pulih'] . "");
  if ($up) {
    echo "<script>window.location='index.php?page=pembelian_alkes2_set'</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PO Luar Negeri (Set)</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pemesanan Alkes</li>
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
                <a href="?page=tambah_pembelian_alkes2_set_sudah_ada"><button name="tambah_laporan" class="btn btn-success" type="button"><span class="fa fa-plus"></span> Tambah</button>
                </a>
                <span class="pull pull-right">
                  <table>
                    <tr>
                      <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Jika Baris Berwarna <strong>Merah</strong> , menandakan PO Sudah Dibatalkan</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">2. </td>
                      <td valign="top"><strong>Status Batal</strong> Hanya Berlaku Jika :<br />
                        1. Belum Dilakukan Pembayaran Oleh Keuangan<br />
                        2. Belum Di Mutasi Oleh Gudang</td>
                    </tr>
                  </table>
                </span>
                <br /><br /><br /><br />
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

  function pulihkan(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Memulihkan Data PO Ini ?',
      text: 'Data Akan Di Buka Kembali',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Pulihkan',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_pulih=' + id;
      }
    })
  }
</script>