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
                <a href="?page=tambah_pembelian_alkes2_sudah_ada"><button name="tambah_laporan" class="btn btn-success" type="button"><span class="fa fa-plus"></span> Tambah</button>
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
                <div class="pull pull-left">
                  <button class="btn btn-info" data-toggle="modal" data-target="#modal-cetak"><span class="fa fa-print"></span> Cetak Rekap</button>
                </div>
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

<div class="modal fade" id="modal-pengiriman">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Data Pengiriman</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="data-pengiriman"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-principle">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Data Principle</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="data-principle"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detailbarang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="modal-barang-pesan"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-cetak">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <center>Cetak Rekapan Pembelian Barang</center>
        </h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="cetakRekapan(); return false;">
        <div class="modal-body">
          <label>Dari Tanggal</label>
          <input name="tgl1" id="tglRekap1" type="date" class="form-control" required placeholder="" value=""><br />
          <label>Sampai Tanggal</label>
          <input name="tgl2" id="tglRekap2" type="date" class="form-control" required placeholder="" value=""><br />
          <label>Jenis PO</label>
          <input disabled class="form-control" value="Luar Negeri">
          <!-- <label>Filter Berdasarkan</label>
          <select class="form-control select2" id="filterRekap" onchange="filterCetak(this.value)" style="width:100%" name="filter">
            <option value="0">...</option>
            <option value="1">Nama Principle</option>
            <option value="2">Provinsi/Kabupaten/Kecamatan</option>
          </select>
          <br><br>
          <div id="filterData"></div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" name="cetak"><i class="fa fa-print"></i> Cetak</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function cetakRekapan() {
    var tgl1 = $('#tglRekap1').val();
    var tgl2 = $('#tglRekap2').val();
    var filter = $('#filterRekap').val();
    var pembeli = $('#pembeli').val();
    var provinsi = $('#provinsi1').val();
    var kabupaten = $('#kabupaten1').val();
    var kecamatan = $('#kecamatan1').val();
    // $.post("cetak_laporan_penjualan_alkes.php",
    //   function(data) {
    window.location.href = 'cetak_laporan_pembelian_alkes.php?tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&jenis_po=2';

    //   }
    // );
  }

  function modalPrinciple(id) {
    $.get("data/modal-principle.php", {
        id: id
      },
      function(data) {
        $('#data-principle').html(data);
        $('#modal-principle').modal('show');
      }
    );
  }

  function modalPengiriman(id) {
    $.get("data/modal-pengiriman.php", {
        id: id
      },
      function(data) {
        $('#data-pengiriman').html(data);
        $('#modal-pengiriman').modal('show')
      }
    );
  }

  function modalBarang(id) {
    $.get("data/modal-barang-pesan.php", {
        id: id
      },
      function(data) {
        $('#modal-barang-pesan').html(data);
        $('#modal-detailbarang').modal('show')
      }
    );
  }

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
        $.post("data/hapus-pembelian-alkes.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              addRiwayat('DELETE', 'barang_dipesan', id, 'Menghapus Pemesanan Luar Negeri')
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
        $.post("data/pulihkan-pembelian-alkes.php", {
            id_pulih: id
          },
          function(data) {
            if (data == 'S') {
              addRiwayat('UPDATE', 'barang_dipesan', id, 'Memulihkan Pembatalan Pemesanan Luar Negeri')
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