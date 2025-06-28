<?php

if (isset($_POST['tambah_spk_masuk'])) {
  $Result = mysqli_query($koneksi, "update alat_pelatihan set banyak_peserta='" . $_POST['peserta'] . "', pelatih='" . $_POST['pelatih'] . "', tgl_pelatihan='" . $_POST['tgl_pelatihan'] . "', pelatihan_oleh='" . $_POST['pelatihan_oleh'] . "' where id=" . $_GET['id'] . "");

  if ($Result) {

    echo "<script type='text/javascript'>
		alert('Silakan Update Data Peserta !');
		window.location='index.php?page=tambah_peserta_pelatihan&id=$_GET[id]';
		</script>";
  }
}

if (isset($_POST['tambahteknisibaru'])) {
  $dat = mysqli_num_rows(mysqli_query($koneksi, "select * from tb_teknisi where nama_teknisi='" . $_POST['nama_teknisi'] . "'"));
  if ($dat == 0) {
    $Result = mysqli_query($koneksi, "insert into tb_teknisi values('','" . $_POST['nama_teknisi'] . "','" . $_POST['bidang'] . "','" . $_POST['no_str'] . "','" . $_POST['no_hp'] . "','" . $_POST['username'] . "','" . md5($_POST['password']) . "','" . $_POST['nama_teknisi'] . "-" . $_FILES['ijazah']['name'] . "','" . $_POST['nama_teknisi'] . "-" . $_FILES['sertifikat']['name'] . "')");
    if ($Result) {
      copy($_FILES['ijazah']['tmp_name'], "ijazah_teknisi/" . $_POST['nama_teknisi'] . "-" . $_FILES['ijazah']['name']);
      copy($_FILES['sertifikat']['tmp_name'], "ijazah_teknisi/sertifikat/" . $_POST['nama_teknisi'] . "-" . $_FILES['sertifikat']['name']);
      echo "<script type='text/javascript'>
		alert('Teknisi Berhasil Di Tambah !');
		window.location='index.php?page=tambah_spk_masuk'
		</script>";
    }
  } else {
    echo "<script type='text/javascript'>
		alert('Nama Teknisi Sudah Ada !');
		window.location='index.php?page=tambah_spk_masuk#tambahTeknisi'
		</script>";
  }
}

if (isset($_POST['lihat'])) {
  echo "<script type='text/javascript'>
	window.location='index.php?page=laporan_laba_rugi&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]';
	</script>";
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Laporan Laba Rugi

    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Laporan Laba Rugi</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <form method="post" enctype="multipart/form-data">
      <div class="row">
        <!-- Left col -->

        <section class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success"><!-- /.chat -->
            <form method="post">
              <br />
              <table align="center">
                <tr>
                  <td>Tanggal Periode Dari &nbsp;</td>
                  <td><input type="date" name="tgl1" id="tgl1" class="form-control" /></td>
                  <td>&nbsp; Sampai &nbsp;</td>
                  <td><input type="date" name="tgl2" id="tgl2" class="form-control" /></td>
                  <td><button name="lihat" type="submit" onclick="getData(); return false;" class="btn btn-success">Lihat</button></td>
                  <?php if (isset($_GET['tgl1'])) { ?>
                    <td>
                      <a target="_blank"><span class="">
                          <div data-toggle="tooltip" title="Cetak Excel" class="btn btn-info" name="cetak_excel"><span class="fa fa-file-excel-o"></span></div>
                        </span></a>
                    </td>
                    <td>
                      <a href="print_laporan_laba_rugi.php?tgl1=<?php echo $_GET['tgl1'] ?>&tgl2=<?php echo $_GET['tgl2'] ?>" target="_blank"><span class="">
                          <div data-toggle="tooltip" title="Print" class="btn btn-danger" name="cetak_pdf"><span class="fa fa-print"></span></div>
                        </span></a>
                    </td>
                  <?php } ?>
                </tr>
              </table>
            </form>
            <div id="data-laba-rugi"></div>
          </div>
        </section>
        <!-- right col -->
      </div>
    </form>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>

<script>
  async function getData() {
    let tgl1 = $('#tgl1').val();
    let tgl2 = $('#tgl2').val();
    showLoading2(1)
    $.get("data/data-laba-rugi.php", {
        tgl1: tgl1,
        tgl2: tgl2,
      },
      function(data) {
        showLoading2(0)
        $('#data-laba-rugi').html(data);
      }
    );
  }

  $(document).ready(function() {
    getData()
  });
</script>