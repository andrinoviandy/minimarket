<?php
if (isset($_GET['id_hapus'])) {
  $sel = mysqli_fetch_array(mysqli_query($koneksi, "select no_po_pesan from barang_pesan_akse where id=" . $_GET['id_hapus'] . ""));
  $del0 = mysqli_query($koneksi, "delete from utang_piutang_aksesoris where no_faktur_no_po_akse='" . $sel['no_po_pesan'] . "'");
  $del2 = mysqli_query($koneksi, "delete from barang_pesan_akse_detail where barang_pesan_akse_id=" . $_GET['id_hapus'] . "");
  $del = mysqli_query($koneksi, "delete from barang_pesan_akse where id=" . $_GET['id_hapus'] . "");
  if ($del0 and $del and $del2) {
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

if (isset($_GET['id_pulih'])) {
  $up = mysqli_query($koneksi, "update barang_pesan_akse set status_po_batal=0,deskripsi_batal='' where id=" . $_GET['id_pulih'] . "");
  if ($up) {
    echo "<script>window.location='index.php?page=pembelian_akse2'</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PO Luar Negeri</h1>
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
                <a href="index.php?page=pembelian_akse2#openPilihan">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button>
                </a>
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


<div id="openPilihan" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <br />
    <a href="index.php?page=tambah_pembelian_akse2"><button id="buttonn">Data Principle Baru</button></a>
    <a href="index.php?page=tambah_pembelian_akse2_sudah_ada">
      <button id="buttonn">Dari Data Principle<br />Yang Sudah Terinput</button></a>
  </div>
</div>

<?php
if (isset($_POST['batal'])) {
  $up = mysqli_query($koneksi, "update barang_pesan_akse set status_po_batal=1,deskripsi_batal='" . $_POST['deskripsi'] . "' where id=" . $_GET['id'] . "");
  if ($up) {
    echo "<script>window.location='index.php?page=pembelian_akse2'</script>";
  }
}
?>
<div id="openBatal" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Deskripsi Batal</h3>
    <form method="post">
      <textarea class="form-control" rows="4" name="deskripsi"></textarea>
      <button id="buttonn" name="batal" type="submit">Simpan</button>
    </form>
  </div>
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