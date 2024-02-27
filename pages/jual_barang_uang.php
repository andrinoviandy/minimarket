<?php
include("include/API.php");

if (isset($_POST['pos'])) {
  $q = mysqli_query($koneksi, "select * from barang_dijual where id=" . $_GET['id'] . "");
  if ($q) {
    echo "<script>
		window.location='index.php?page=tambah_pembelian';
		alert('Berhasil di Simpan !');
		</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Penjualan Alkes
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Jual Alkes</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <section class="col-lg-12">
        <div class="box box-body">
          <?php if (isset($_SESSION['administrator']) or isset($_SESSION['adminkeuangan']) or isset($_SESSION['adminmanajerkeuangan']) or isset($_SESSION['adminpoluar'])) {
          ?>
            <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
              <a href="?page=jual_alkes2">
                <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></a>
            </div>
          <?php } ?>
          <form method="post" action="cetak_marketing.php">
            <div class="input-group pull pull-left col-xs-3">
              <select class="form-control select2" name="marketing" style="margin-right:40px">
                <option value="all">All Marketing</option>
                <?php
                $q = mysqli_query($koneksi, "select marketing,subdis from barang_dijual group by marketing order by marketing ASC");
                while ($d = mysqli_fetch_array($q)) {
                ?>
                  <option value="<?php echo $d['marketing']; ?>"><?php echo $d['marketing']; ?></option>
                <?php } ?>
              </select><br />
              <select class="form-control select2" name="tahun" style="margin-right:40px">
                <?php
                $t1 = mysqli_fetch_array(mysqli_query($koneksi, "select min(tgl_jual) as tgl_min from barang_dijual"));
                $t2 = mysqli_fetch_array(mysqli_query($koneksi, "select max(tgl_jual) as tgl_max from barang_dijual"));
                $thn1 = date("Y", strtotime($t1['tgl_min']));
                $thn2 = date("Y", strtotime($t2['tgl_max']));
                for ($i = $thn1; $i <= $thn2; $i++) {
                ?>
                  <option <?php if (date("Y") == $i) {
                            echo "selected";
                          } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
              </select>
              <span class="input-group-btn">
                <button type="submit" name="button_urut" class="btn btn-warning" style="padding-top:22px; padding-bottom:22px">Cetak</button>
              </span>

            </div>
          </form>
          <?php //} 
          ?>
          <span class="pull pull-right">
            <table>
              <tr>
                <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                <td valign="top">1. </td>
                <td valign="top">Tanda &quot;<span class="fa fa-plane"></span>&quot; menandakan barang sudah di kirim</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td valign="top">2. </td>
                <td>Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                  barang telah dikembalikan karena mengalami kerusakan</td>
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

      </section>
      <?php include "include/header_pencarian.php"; ?>
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-info">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <div class="">
                <?php //if (isset($_SESSION['user_administrator']) or isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_manajer_gudang'])) { 
                ?>
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

      <!-- /.content -->

      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>

<div class="modal fade" id="modal-cetak">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <center>Cetak Rekapan Penjualan Barang</center>
        </h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="cetakRekapan(); return false;">
        <div class="modal-body">
          <label>Dari Tanggal</label>
          <input name="tgl1" id="tglRekap1" type="date" class="form-control" required placeholder="" value=""><br />
          <label>Sampai Tanggal</label>
          <input name="tgl2" id="tglRekap2" type="date" class="form-control" required placeholder="" value=""><br />
          <label>Filter Berdasarkan</label>
          <select class="form-control select2" id="filterRekap" onchange="filterCetak(this.value)" style="width:100%" name="filter">
            <option value="0">...</option>
            <option value="1">Nama Dinas/RS/Dll</option>
            <option value="2">Provinsi/Kabupaten/Kecamatan</option>
          </select>
          <br><br>
          <div id="filterData"></div>
          <label>Status Barang</label>
          <select class="form-control select2" id="statusRekap" style="width:100%" name="status">
            <option value="Semua">Semua</option>
            <option value="Sudah Terkirim">Sudah Terkirim</option>
          </select>
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

<div class="modal fade" id="modal-pembeli">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Data RS/Dinas/Klinik/Dll</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="modal-data-pembeli"></div>
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

<div class="modal fade" id="modal-barang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="modal-data-barang"></div>
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

<div class="modal fade" id="modal-cetak-faktur">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cetak Faktur</h4>
      </div>
      <div class="modal-body">
        <a id="cetak_biasa" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Biasa</a>
        <a id="cetak_ritel" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> Ritel</a>
        <a id="cetak_ekatalog" target="_blank" class="btn btn-app"><i class="fa fa-print"></i> E-Katalog</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-instalasi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Instalasi & Uji Fungsi</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="modal-data-instalasi"></div>
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

<script>
  function cetakRekapan() {
    var tgl1 = $('#tglRekap1').val();
    var tgl2 = $('#tglRekap2').val();
    var filter = $('#filterRekap').val();
    var pembeli = $('#pembeli').val();
    var provinsi = $('#provinsi1').val();
    var kabupaten = $('#kabupaten1').val();
    var kecamatan = $('#kecamatan1').val();
    var status = $('#statusRekap').val();
    // $.post("cetak_laporan_penjualan_alkes.php",
    //   function(data) {
    if (filter == 1) {
      window.location.href = 'cetak_laporan_penjualan_alkes.php?filter=1&pembeli=' + pembeli + '&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&status=' + status;
    } else if (filter == 2) {
      window.location.href = 'cetak_laporan_penjualan_alkes.php?filter=2&provinsi=' + provinsi + '&kabupaten=' + kabupaten + '&kecamatan=' + kecamatan + '&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&status=' + status;
    } else {
      window.location.href = 'cetak_laporan_penjualan_alkes.php?tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&status=' + status;
    }
    //   }
    // );
  }

  function filterCetak(param) {
    if (param == '1') {
      $.get("data/modal-dinas-rs.php",
        function(data) {
          $('#filterData').html(data);
        }
      );
    } else if (param == '2') {
      $.get("data/modal-provinsi-kabupaten-kecamatan.php",
        function(data) {
          $('#filterData').html(data);
        }
      );
    } else {
      $('#filterData').html('');
    }
  }

  function modalCetak(id) {
    $('#cetak_biasa').prop('href', 'cetak_faktur_penjualan_uang.php?id=' + id)
    $('#cetak_ritel').prop('href', 'cetak_faktur_penjualan_uang_ritel.php?id=' + id)
    $('#cetak_ekatalog').prop('href', 'cetak_faktur_penjualan_uang_ekatalog.php?id=' + id)
    $('#modal-cetak-faktur').modal('show');
  }

  function batalkanPenjualan(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Yakin Akan Membatalkan Penjualan Ini ? ?',
      text: 'Proses ini akan berhasil jika bagian gudang belum memilih no seri atau belum ada pembayaran di keuangan !',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/batalkan-penjualan.php", {
            id_batal: id
          },
          function(data) {
            if (data == 'S') {
              loadMore(load_flag, key, status_b)
              alertCustom('S', 'Penjualan Berhasil Dibatalkan !', '')
            } else if (data == 'TB') {
              alertCustom('W', 'Penjualan Tidak Dapat Dibatalkan !', 'Karena Sudah Ada Pengiriman atau Sudah Ada Pembayaran! Silakan Cek Data Pengiriman atau Data Piutang')
            } else {
              alertCustom('А', 'Penjualan Gagal Dibatalkan !', '')
            }
          }
        );
      }
    })
  }

  function modalBarang(no_po) {
    $('#modal-data-barang').html('<center><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></center>');
    $('#modal-barang').modal('show');
    $.get("data/modal-barang-jual.php", {
        no_po_jual: no_po
      },
      function(data) {
        $('#modal-data-barang').html(data)
      }
    );
  }

  function modalPembeli(id) {
    $('#modal-pembeli').modal('show');
    $.get("data/modal-pembeli.php", {
        id: id
      },
      function(data) {
        $('#modal-data-pembeli').html(data)
      }
    );
  }

  function modalInstalasi(no_po) {
    $('#modal-instalasi').modal('show');
    $.get("data/modal-instalasi-jual.php", {
        no_po_jual: no_po
      },
      function(data) {
        $('#modal-data-instalasi').html(data)
      }
    );
  }
</script>