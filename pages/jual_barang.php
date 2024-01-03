<?php

if (isset($_POST['kirim_barang'])) {
  mysqli_query($koneksi, "delete from barang_dikirim_detail_hash where akun_id=" . $_SESSION['id'] . "");

  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_peng'];
  $_SESSION['ekspedisi'] = $_POST['ekspedisi'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['via_pengiriman'] = $_POST['via_kirim'];
  $_SESSION['estimasi'] = $_POST['estimasi_brg_sampai'];
  $_SESSION['biaya_kirim'] = str_replace(".", "", $_POST['biaya_kirim']);
  $_SESSION['no_po'] = $_POST['no_po'];

  echo "<script type='text/javascript'>
		window.location='index.php?page=pilih_no_seri&id=" . $_POST['id_kirim'] . "';
		</script>";
}

if (isset($_GET['id_batal'])) {
  $se = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_detail where status_kirim=1 and barang_dijual_id=" . $_GET['id_batal'] . ""));
  if ($se != 0) {
    echo "<script>
    alert('Data tidak dapat dibatalkan karena sudah dikirim ! Silakan batalkan proses kirim terlebih dahulu !');
		window.location='index.php?page=jual_barang';
		</script>";
  } else {
    $sd = mysqli_query($koneksi, "select * from barang_dijual_detail where status_kirim=0 and barang_dijual_id=" . $_GET['id_batal'] . "");
    while ($da = mysqli_fetch_array($sd)) {
      $upp = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set stok_total=stok_total+1, status_terjual=0 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $da['barang_gudang_detail_id'] . "");
    }
    if ($upp) {
      mysqli_query($koneksi, "delete from barang_dijual_detail where barang_dijual_id=" . $_GET['id_batal'] . "");
      mysqli_query($koneksi, "delete from barang_dijual where id=" . $_GET['id_batal'] . "");
      echo "<script>alert('Pembatalan berhasil !');
		window.location='index.php?page=jual_barang';
		</script>";
    } else {
      echo "<script>alert('Pembatalan Gagal !');
		window.location='index.php?page=jual_barang';
		</script>";
    }
  }
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengiriman Alkes
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
          <div id="modal-data"></div>
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

<div class="modal fade" id="modal-detail-barang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <div class="modal-body">
        <div id="modal-data-barang"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-sisa-kirim">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Sisa Belum Di Kirim</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div id="modal-data-sisa"></div>
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
  function modalPembeli(id) {
    $('#modal-pembeli').modal('show');
    $.get("data/modal-pembeli.php", {
        id: id
      },
      function(data) {
        $('#modal-data').html(data)
      }
    );
  }

  function modalDetailBarang(id) {
    $('#modal-detail-barang').modal('show');
    $.get("data/modal-detail-barang.php", {
        id: id
      },
      function(data) {
        $('#modal-data-barang').html(data)
      }
    );
  }

  function modalSisaKirim(id) {
    $('#modal-sisa-kirim').modal('show');
    // $.get("data/modal-sisa-kirim.php", {
    $.get("data/data_detail_kirim.php", {
        id: id
      },
      function(data) {
        $('#modal-data-sisa').html(data)
      }
    );
  }
</script>