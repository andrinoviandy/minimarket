<?php
if (isset($_POST['simpan'])) {
  $Result = mysqli_query($koneksi, "insert into stok_opname values(NULL,'" . $_POST['tgl'] . "','" . $_POST['keterangan'] . "')");

  if ($Result) {
    $sel = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as idd from stok_opname"));
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Disimpan , Silakan Scanner Barang',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=opname&id=$sel[idd]';
      } else {
        window.location.href = '?page=opname&id=$sel[idd]';
      }
    })
    </script>";
  }
}

if (isset($_POST['simpan2'])) {
  echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Silakan Lanjut Scanner Barang ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=opname&id=$_POST[tgl]';
      }
    })
    </script>";
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

$data = mysqli_fetch_array(mysqli_query($koneksi, "select * from stok_opname where id= $_GET[id]"));
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Detail Stok Opname
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Detail Stok Opname</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->

    <div class="row">
      <!-- Left col -->
      <section class="col-lg-2 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <h3 align="center">Data</h3>
          <div class="box-footer">
            <div class="box-header with-border">
              <div class="bob-body">
                <label>Tanggal Pengecekan</label><br>
                <em><?php echo date("d/m/Y", strtotime($data['tgl_cek'])) ?></em>
                <br /><br>
                <label>Keterangan</label><br>
                <em align="justify"><?php echo $data['keterangan'] ?></em>
                <br /><br>
                <button type="button" name="simpan" class="btn btn-success" onclick="window.location.href = '?page=opname_awal'">
                  <i class="fa fa-calendar"></i>
                  &nbsp;Kembali
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="col-lg-5 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-warning">
          <!-- /.chat -->
          <h3 align="center">Ditemukan</h3>
          <div class="box-footer">
            <div class="box-header with-border">
              <div class="bob-body">
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
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
            </div>
          </div>
        </div>
      </section>
      <section class="col-lg-5 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-warning">
          <!-- /.chat -->
          <h3 align="center">Tidak Ditemukan</h3>
          <div class="box-footer">
            <div class="box-header with-border">
              <div class="bob-body">
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>
                <div class="row">
                  <div class="col-lg-6 pull-right">
                    <form method="post" onsubmit="form_cari2(); return false;">
                      <div class="input-group">
                        <input type="text" class="form-control" name="keyword2" id="keyword2" placeholder="Masukkan Kata Kunci Pencarian..." />
                        <span class="input-group-btn">
                          <button type="button" onclick="form_cari2(); return false;" name="tampilkan" id="btn-cari" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>
                <div id="table2" style="margin-top: 10px;"></div>
                <section class="col-lg-12">
                  <center>
                    <ul class="pagination">
                      <button class="btn btn-default" id="paging-1_2"><a><i class="fa fa-angle-double-left"></i></a></button>
                      <button class="btn btn-default" id="paging-2_2"><a><i class="fa fa-angle-double-right"></i></a></button>
                    </ul>
                    <?php
                    echo "<br/> Data Yang Ditampilkan : <font id='dari2'></font>....<font id='sampai2'></font>";
                    ?>
                  </center>
                </section>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- right col -->
    </div>

    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<?php
if (isset($_POST['simpan_1'])) {
  $id = $_GET['id'];
  $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_pelatihan"));
  $ext = explode(".", $_FILES['lamp1']['name']);
  $ext2 = explode(".", $_FILES['lamp2']['name']);
  $lamp1 = "Lampiran1_" . $max['maks'] . "." . $ext[1];
  $lamp2 = "Lampiran2_" . $max['maks'] . "." . $ext2[1];
  $R = mysqli_query($koneksi, "update alat_pelatihan set lamp1='$lamp1' where id=$id");
  if ($R) {
    copy($_FILES['lamp1']['tmp_name'], "gambar_pelatihan/lampiran1/$lamp1");
    echo "<script type='text/javascript'>
		  window.location='index.php?page=ubah_latih&id=$id';
		</script>";
  }
}

if (isset($_POST['simpan_2'])) {
  $id = $_GET['id'];
  $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_pelatihan"));
  $ext = explode(".", $_FILES['lamp1']['name']);
  $ext2 = explode(".", $_FILES['lamp2']['name']);
  $lamp1 = "Lampiran1_" . $max['maks'] . "." . $ext[1];
  $lamp2 = "Lampiran2_" . $max['maks'] . "." . $ext2[1];
  $R = mysqli_query($koneksi, "update alat_pelatihan set lamp2='$lamp2' where id=$id");
  if ($R) {
    copy($_FILES['lamp2']['tmp_name'], "gambar_pelatihan/lampiran2/$lamp2");
    echo "<script type='text/javascript'>
		  window.location='index.php?page=ubah_latih&id=$id';
		</script>";
  }
}
?>
<div id="open1" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Lampiran 1</h3>
    <form method="post" enctype="multipart/form-data">
      <input id="input" name="lamp1" type="file" style="background-color:#FFF" />
      <button id="buttonn" name="simpan_1" type="submit">Simpan</button>
    </form>
  </div>
</div>

<div id="open2" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Lampiran 2</h3>
    <form method="post" enctype="multipart/form-data">
      <input id="input" name="lamp2" type="file" style="background-color:#FFF" />
      <button id="buttonn" name="simpan_2" type="submit">Simpan</button>
    </form>
  </div>
</div>