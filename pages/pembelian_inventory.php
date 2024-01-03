<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PO Dalam Negeri</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pemesanan Barang Inventory</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <section class="col-lg-12">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-default">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <a href="index.php?page=pembelian_inventory#openPilihan">
                  <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
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
                        1. Belum Dilakukan Pembayaran Oleh Keuangan</td>
                    </tr>
                  </table>
                </span>
                <br><br><br>
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
      <!-- Left col -->
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
    <a href="index.php?page=tambah_pembelian_inven"><button id="buttonn">Data Principle Baru</button></a>
    <a href="index.php?page=tambah_pembelian_inven_sudah_ada">
      <button id="buttonn">Dari Data Principle<br />Yang Sudah Terinput</button></a>
  </div>
</div>
<?php
if (isset($_POST['batal'])) {
  $up = mysqli_query($koneksi, "update barang_pesan_inventory set status_po_batal=1,deskripsi_batal='" . $_POST['deskripsi'] . "' where id=" . $_GET['id'] . "");
  if ($up) {
    echo "<script>window.location='index.php?page=pembelian_inventory'</script>";
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
        $.post("data/hapus-pembelian-inventory.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              loadMore(load_flag, key, status_b);
            } else {
              alertHapus('F');
            }
          }
        );
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
        $.post("data/pulihkan-pembelian-inventory.php", {
            id_pulih: id
          },
          function(data) {
            if (data == 'S') {
              alertCustom('S', 'Berhasil Dipulihkan !', '');
              loadMore(load_flag, key, status_b);
            } else {
              alertCustom('F', 'Gagal Dipulihkan !', '');
            }
          }
        );
      }
    })
  }
</script>