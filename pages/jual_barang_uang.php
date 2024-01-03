<?php
include("include/API.php");

if (isset($_GET['id_batal'])) {
  $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_GET['id_batal'] . ""));
  $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from utang_piutang,utang_piutang_bayar where utang_piutang.id=utang_piutang_bayar.utang_piutang_id and no_faktur_no_po='" . $sel['no_po_jual'] . "'"));
  if ($cek == 0) {
    $del1 = mysqli_query($koneksi, "delete from barang_dijual_qty where barang_dijual_id='" . $_GET['id_batal'] . "'");
    $del2 = mysqli_query($koneksi, "delete from barang_dijual where id='" . $_GET['id_batal'] . "'");
    if ($del2) {
      echo "<script type='text/javascript'>
      window.location='index.php?page=jual_barang_uang';
      alert('Berhasil di Dibatalkan !');
      </script>";
    } else {
      echo "<script type='text/javascript'>alert('Maaf Data Tidak Dapat Di Hapus , Karena Sudah Ada Pengiriman atau Sudah Ada Pembayaran! Silakan Cek Data Pengiriman atau Data Piutang');
		history.back();
		</script>";
    }
  } else {
    echo "<script type='text/javascript'>alert('Maaf Data Tidak Dapat Di Hapus , Karena Sudah Ada Pengiriman atau Sudah Ada Pembayaran! Silakan Cek Data Pengiriman atau Data Piutang');
		history.back();
		</script>";
  }
  /*$se = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_detail where status_kirim=1 and barang_dijual_id=".$_GET['id_batal'].""));
	if ($se!=0) {
		echo "<script>alert('Data tidak dapat dibatalkan karena sudah dikirim ! Silakan batalkan proses kirim terlebih dahulu !');
		window.location='index.php?page=jual_barang';
		</script>";
		}
	else {
		$sd = mysqli_query($koneksi, "select * from barang_dijual_detail where status_kirim=0 and barang_dijual_id=".$_GET['id_batal']."");
		while ($da = mysqli_fetch_array($sd)) {
			$upp=mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set stok_total=stok_total+1, status_terjual=0 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=".$da['barang_gudang_detail_id']."");
			}
		if ($upp) {
			mysqli_query($koneksi, "delete from barang_dijual_detail where barang_dijual_id=".$_GET['id_batal']."");
			mysqli_query($koneksi, "delete from barang_dijual where id=".$_GET['id_batal']."");
			echo "<script>alert('Pembatalan berhasil !');
		window.location='index.php?page=jual_barang';
		</script>";
			}
			else {
				echo "<script>alert('Pembatalan Gagal !');
		window.location='index.php?page=jual_barang';
		</script>";
				}
		}*/
}
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
          <?php if (isset($_SESSION['administrator']) or isset($_SESSION['adminkeuangan']) or isset($_SESSION['adminmanajerkeuangan'])) {
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
            <button class="btn btn-info" data-toggle="modal" data-target="#modal-cetak"><span class="fa fa-print"></span> Cetak</button>
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
          <center>Cetak Penjualan Barang</center>
        </h4>
      </div>
      <form method="post" enctype="multipart/form-data" action="cetak_laporan_penjualan_alkes.php">
        <div class="modal-body">
          <label>Dari Tanggal</label>
          <input name="tgl1" type="date" class="form-control" placeholder="" value=""><br />
          <label>Sampai Tanggal</label>
          <input name="tgl2" type="date" class="form-control" placeholder="" value=""><br />
          <label>Status Barang</label>
          <select class="form-control" style="width:100%" name="status">
            <option value="Semua">Semua</option>
            <option value="Sudah Terkirim">Sudah Terkirim</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" name="cetak">Cetak</button>
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
  function modalBarang(no_po) {
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