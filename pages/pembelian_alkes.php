<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      PO Dalam Negeri</h1>
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
                <a href="?page=tambah_pembelian_alkes_sudah_ada"><button name="tambah_laporan" class="btn btn-success" type="button"><span class="fa fa-plus"></span> Tambah</button>
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
      <?php //include "include/header_pencarian.php"; ?>
      <div id="header_pencarian"></div>
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
      <!-- /.content -->
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
        $.post("data/hapus-pembelian-alkes.php", {id_hapus: id},
          function (data) {
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
        $.post("data/pulihkan-pembelian-alkes.php", {id_pulih: id},
          function (data) {
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