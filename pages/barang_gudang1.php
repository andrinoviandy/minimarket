<?php
if (isset($_POST['lihat'])) {
  echo "<script>
	window.location='index.php?page=barang_gudang1&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&mutasi=$_POST[mutasi]';
	</script>";
}

if (isset($_POST['print'])) {
  echo "<script>
	window.open('print_barang_gudang1.php&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&mutasi=$_POST[mutasi]', '_blank');
	</script>";
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php if (isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_manajer_gudang'])) { ?>
        Gudang 1
      <?php } else if (isset($_SESSION['user_admin_keuangan']) or isset($_SESSION['user_manajer_keuangan'])) {
        echo "Pembelian";
      } else {
        echo "Gudang 1 / Pembelian";
      } ?>
    </h1>
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
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-default">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body table-responsive no-padding">
              <div class="">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                  <i class="fa fa-eye"></i> Lihat
                </button>
                <?php if (isset($_GET['mutasi'])) { ?>
                  <a href="index.php?page=barang_gudang1"><button class="btn btn-warning">Reset</button></a>
                <?php } ?>
                <span class="pull pull-right">
                  <table>
                    <tr>
                      <td><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Tanda "<span class="fa fa-share"></span>" Menandakan Sudah Di Mutasi ke Gudang Utama / Gudang 2</td>
                    </tr>
                  </table>
                </span>
                <br />
                <br />
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
              <div class="">
                <div class="pull pull-left">
                  <select class="form-control" name="jenis_po" id="jenis_po" onchange="ubahJenisPO();">
                    <option value="All" selected>Semua</option>
                    <option value="Dalam Negeri">Dalam Negeri</option>
                    <option value="Luar Negeri">Luar Negeri</option>
                  </select>
                </div>
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
              <br />

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


<section class="col-lg-2">
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Lihat</h4>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <label>Dari Tanggal</label>
            <input type="date" name="tgl1" class="form-control" />
            <br />
            <label>Sampai Tanggal</label>
            <input type="date" name="tgl2" class="form-control" />
            <br />
            <label>Mutasi</label>
            <select name="mutasi" class="form-control select2" style="width:100%" required>
              <option value="">...</option>
              <option value="0">Belum Mutasi</option>
              <option value="1">Sudah Mutasi</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" name="lihat" class="btn btn-primary">Lihat</button>
            <!--<button type="submit" name="print" class="btn btn-info">Print</button>-->
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</section>

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

<div class="modal fade" id="modal-tglmasuk">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tanggal Masuk Gudang</h4>
      </div>
      <form method="post" enctype="multipart/form-data" onsubmit="simpanTgl(); return false;">
        <div class="modal-body">
          <input type="hidden" name="id_tgl" id="id_tgl" />
          <input id="input" type="date" class="form-control" name="tgl_lunas">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="lunasin" type="submit" class="btn btn-success">Simpan</button>
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
    window.location.href = 'cetak_laporan_pembelian_alkes_gudang.php?tgl1=' + tgl1 + '&tgl2=' + tgl2;
    
    //   }
    // );
  }

  function modalBarang(id) {
    $('#modal-detailbarang').modal('show');
    loading2('#modal-data-barang')
    $.get("data/modal-barang-gudang1.php", {
        id: id
      },
      function(data) {
        $('#modal-data-barang').html(data)
      }
    );
  }

  function modalTanggalMasuk(id, tgl) {
    $('#id_tgl').val(id);
    $('#input').val(tgl);
    $('#modal-tglmasuk').modal('show');
  }

  let tgl_masuk = '';

  function ubahTgl(tgl) {
    tgl_masuk = tgl
  }

  function simpanTgl() {
    $.post("data/simpan-tanggal-masuk.php", {
        id: $('#id_tgl').val(),
        tgl: $('#input').val()
      },
      function(data) {
        if (data == 'S') {
          $('#modal-tglmasuk').modal('hide');
          // addRiwayat('INSERT', 'barang_gudang', id, 'Menghapus Barang')
          loadMore(load_flag, key, status_b)
          alertSimpan('S');
        } else {
          alertSimpan('F');
        }
      }
    );
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

  function ubahJenisPO() {
    let keyy = $('#keyword').val();
    loading()
    loadMore(load_flag, keyy)
  }
</script>