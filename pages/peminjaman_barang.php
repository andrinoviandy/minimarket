<?php
if (isset($_POST['pencarian'])) {
  if ($_POST['pilihan'] == 'tgl_peminjaman') {
    echo "<script>window.location='index.php?page=peminjaman_barang&tgl_awal=$_POST[tgl_awal]&tgl_akhir=$_POST[tgl_akhir]&tampil=$_POST[tampil]'</script>";
  } else {
    echo "<script>window.location='index.php?page=peminjaman_barang&pilihan=$_POST[pilihan]&kunci=$_POST[kata_kunci]&tampil=$_POST[tampil]'</script>";
  }
}

if (isset($_POST['kirim_barang'])) {
  mysqli_query($koneksi, "delete from barang_pinjam_kirim_detail_hash where akun_id=" . $_SESSION['id'] . "");
  $_SESSION['lokasi_tujuan'] = $_POST['lokasi_tujuan'];
  $_SESSION['nama_paket'] = $_POST['nama_paket'];
  $_SESSION['no_pengiriman'] = $_POST['no_peng'];
  $_SESSION['ekspedisi'] = $_POST['ekspedisi'];
  $_SESSION['tgl_pengiriman'] = $_POST['tgl_kirim'];
  $_SESSION['via_pengiriman'] = $_POST['via_kirim'];
  $_SESSION['estimasi'] = $_POST['estimasi_brg_sampai'];
  $_SESSION['biaya_kirim'] = $_POST['biaya_kirim'];
  $_SESSION['no_po'] = $_POST['no_po'];
  $_SESSION['keterangan'] = str_replace("\n", "<br>", $_POST['keterangan']);
  echo "<script type='text/javascript'>
		window.location='index.php?page=pilih_no_seri_pinjam&id=" . $_POST['id_kirim'] . "';
		</script>";
}

if (isset($_GET['id_hapus'])) {
  $d1 = mysqli_query($koneksi, "delete from barang_pinjam_detail where barang_pinjam_id=" . $_GET['id_hapus'] . "");
  $d2 = mysqli_query($koneksi, "delete from barang_pinjam where id=" . $_GET['id_hapus'] . "");
  if ($d1 and $d2) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Dihapus ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(()=> {
      window.location.href = '?page=$_GET[page]';
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
    }).then(()=> {
      window.location.href = '?page=$_GET[page]';
    })
    </script>";
  }
}
if (isset($_GET['id_ubah'])) {
  $sel = mysqli_query($koneksi, "select * from barang_demo_detail where barang_demo_id=" . $_GET['id_ubah'] . "");
  while ($d = mysqli_fetch_array($sel)) {
    $up_stok = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total+1,status_demo=0 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $d['barang_gudang_detail_id'] . "");
  }
  if ($up_stok) {
    mysqli_query($koneksi, "update barang_demo set status=1 where id=" . $_GET['id_ubah'] . "");
    echo "<script type='text/javascript'>
		window.location='index.php?page=barang_demo';
		</script>";
  }
}

if (isset($_POST['simpan_tanggal'])) {
  $up_stok = mysqli_query($koneksi, "update barang_pinjam_detail set tgl_pengembalian='" . $_POST['tgl_pengembalian'] . "' where id=" . $_POST['barang_pinjam_detail_id'] . "");
  if ($up_stok) {
    echo "<script type='text/javascript'>
		window.location='index.php?page=peminjaman_barang';
		</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Peminjaman Barang</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
        <div class="box box-body">
          <div class="input-group pull pull-left col-xs-1" style="padding-right:10px">
            <?php if (isset($_SESSION['user_admin_gudang']) or isset($_SESSION['user_administrator'])) { ?>
              <a href="index.php?page=tambah_peminjaman_barang">
                <button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah </button></a>
            <?php } ?>
          </div>

          <!--<form method="post" action="cetak_stok_alkes.php">-->

          <div class="pull pull-right">
            <?php include "include/getFilter.php";
            ?>
            <?php include "include/atur_halaman.php"; ?>
          </div>
        </div>

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

<div class="modal fade" id="modal-pencarian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <script type="text/javascript">
          function yesnoCheck() {
            if (document.getElementById('yesCheck').value == 'tgl_peminjaman') {
              document.getElementById('ifYes').style.display = 'block';
              document.getElementById('kata_kunci').style.display = 'none';
            } else {
              document.getElementById('ifYes').style.display = 'none';
              document.getElementById('kata_kunci').style.display = 'block';
            }
          }
        </script>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pencarian</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <select class="form-control select2" name="pilihan" required style="width:100%" onchange="javascript:yesnoCheck();" id="yesCheck">
            <option value="">...</option>
            <option value="tgl_peminjaman">Berdasarkan Rentang Tanggal Peminjaman</option>
            <option value="nama_pembeli">Berdasarkan Nama RS/Dinas/Klinik/Dll</option>
            <option value="nama_brg">Berdasarkan Nama Barang</option>
            <option value="tipe_brg">Berdasarkan Tipe Barang</option>
            <option value="no_seri_brg">Berdasarkan No Seri Barang</option>
          </select>
          <br /><br />
          <div id="kata_kunci" style="display:block">
            <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" />
          </div>
          <div id="ifYes" style="display:none">
            <label>Dari Tanggal</label>
            <input name="tgl_awal" type="date" class="form-control" placeholder="" value=""><br />
            <label>Sampai Tanggal</label>
            <input name="tgl_akhir" type="date" class="form-control" placeholder="" value="">
          </div>
          <br />
          <select name="tampil" class="form-control select2" style="width:100%">
            <option value="">...</option>
            <option value="1">Tampilkan Detail Barang</option>
            <option value="0">Tidak Tampilkan Detail Barang</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="pencarian">Cari</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function hapus(id_hapus) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Data AKan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id_hapus;
      }
    })
  }
</script>