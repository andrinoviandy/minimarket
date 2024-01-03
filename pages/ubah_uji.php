<?php
if (isset($_POST['ubah_uji'])) {
  $u = mysqli_query($koneksi, "update alat_uji_detail set soft_version='" . $_POST['soft_version'] . "',tgl_garansi_habis='" . $_POST['tgl_garansi'] . "',tgl_i='" . $_POST['tgl_i'] . "', tgl_f='" . $_POST['tgl_f'] . "', keterangan='" . $_POST['keterangan'] . "' where id=" . $_POST['id_ubah'] . "");
  if ($u) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Diubah ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=ubah_uji&id_rumkit=$_GET[id_rumkit]';
    })
    </script>";
  }
}

if (isset($_POST['ubahlampiran2'])) {

  $qq = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_uji_detail where id=" . $_POST['id_f'] . ""));
  unlink("gambar_fi/fungsi/$qq[lampiran_f]");
  $max2 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_uji_detail"));
  $ext2 = explode(".", $_FILES['lampiran_f']['name']);
  if ($_FILES['lampiran_f']['name'] != '') {
    $lamp_f = "Fungsi" . $_POST['id_f'] . "." . $ext2[1];
  } else {
    $lamp_f = "";
  }
  $u2 = mysqli_query($koneksi, "update alat_uji_detail set lampiran_f='" . $lamp_f . "' where id=" . $_POST['id_f'] . "");
  if ($u2) {
    copy($_FILES['lampiran_f']['tmp_name'], "gambar_fi/fungsi/" . $lamp_f);
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Diubah ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=ubah_uji&id_rumkit=$_GET[id_rumkit]';
    })
    </script>";
  }
}

if (isset($_POST['ubahlampiran1'])) {

  $qq = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_uji_detail where id=" . $_POST['id_i'] . ""));
  unlink("gambar_fi/instalasi/$qq[lampiran_i]");
  $max2 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_uji_detail"));
  $ext2 = explode(".", $_FILES['lampiran_i']['name']);
  if ($_FILES['lampiran_i']['name'] != '') {
    $lamp_f = $_POST['id_i'] . "." . $ext2[1];
  } else {
    $lamp_f = "";
  }
  $u2 = mysqli_query($koneksi, "update alat_uji_detail set lampiran_i='" . $lamp_f . "' where id=" . $_POST['id_i'] . "");
  if ($u2) {
    copy($_FILES['lampiran_i']['tmp_name'], "gambar_fi/instalasi/" . $lamp_f);
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Diubah ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=ubah_uji&id_rumkit=$_GET[id_rumkit]';
    })
    </script>";
  }
}

if (isset($_GET['id_hapus'])) {
  $d = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_uji_detail where id=$_GET[id_hapus]"));
  unlink("../gambar_fi/instalasi/$d[lampiran_i]");
  unlink("../gambar_fi/fungsi/$d[lampiran_f]");
  $hapus = mysqli_query($koneksi, "delete from alat_uji_detail where id=" . $_GET['id_hapus'] . "");
  if ($hapus) {
    mysqli_query($koneksi, "update barang_teknisi_detail set status_uji=0 where id=$d[barang_teknisi_detail_id]");
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Dihapus ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=ubah_uji&id_rumkit=$_GET[id_rumkit]';
    })
    </script>";
  } else {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Tidak Dapat Dihapus',
      text: 'Kemungkinan Masih Ada Data di Pelatihan , Silakan Hapus Dulu di Pelatihan',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=ubah_uji&id_rumkit=$_GET[id_rumkit]';
    })
    </script>";
  }
}

if (isset($_POST['tambah_laporan'])) {
  $Result = mysqli_query($koneksi, "insert into alat_uji_detail values('','" . $_POST['id_akse'] . "','" . $_POST['soft_version'] . "','" . $_POST['tgl_garansi_habis'] . "','" . $_POST['tgl_i'] . "','" . $_POST['lampiran_i'] . "','" . $_POST['tgl_f'] . "','" . $_POST['lampiran_f'] . "','" . $_POST['keterangan'] . "')");
  if ($Result) {
    mysqli_query($koneksi, "update barang_teknisi_detail set status_uji=1 where id=" . $_POST['id_akse'] . "");
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Disimpan ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=simpan_tambah_uji&id=$_GET[id]';
    })
    </script>";
  }
}
?>
<?php

if (isset($_GET['simpan_barang']) == 1) {

  //$insert_pembeli=mysqli_query($koneksi, "insert into pembeli values('','".$_SESSION['pembeli']."','".$_SESSION['provinsi']."','".$_SESSION['kabupaten']."','".$_SESSION['kecamatan']."','".$_SESSION['kelurahan']."','".$_SESSION['alamat']."','".$_SESSION['kontak_rs']."')");

  $insert_pemakai = mysqli_query($koneksi, "insert into pemakai values('','" . $_SESSION['pemakai'] . "','" . $_SESSION['kontak1'] . "','" . $_SESSION['kontak2'] . "','" . $_SESSION['email'] . "')");

  //$pembeli=mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pembeli from pembeli"));
  $id_pembeli = $_SESSION['pembeli'];
  $pemakai = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_pemakai from pemakai"));
  $id_pemakai = $pemakai['id_pemakai'];
  //simpan barang dijual
  $total = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash"));
  $simpan1 = mysqli_query($koneksi, "insert into barang_dijual values('','" . $_SESSION['tgl_jual'] . "','$total','$id_pembeli','$id_pemakai')");

  $d1 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_jual from barang_dijual"));
  $id_jual = $d1['id_jual'];
  //simpan barang pesan detail
  $q2 = mysqli_query($koneksi, "select * from barang_dijual_hash");
  $jml_baris = mysqli_num_rows($q2);
  for ($i = 1; $i <= $jml_baris; $i++) {
    $d2 = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual_hash where no=$i"));
    $simpan2 = mysqli_query($koneksi, "insert into barang_dijual_detail values('','$id_jual','" . $d2['barang_gudang_detail_id'] . "','0')");
    $up = mysqli_query($koneksi, "update barang_gudang_detail set status_terjual=1 where id=" . $d2['barang_gudang_detail_id'] . "");
    $up2 = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $d2['barang_gudang_detail_id'] . "");
  }
  if ($simpan1 and $simpan2) {
    mysqli_query($koneksi, "delete from barang_dijual_hash");
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Disimpan ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      window.location='index.php?page=jual_barang';
    })
    </script>";
  }
}


if (isset($_POST['simpan_tambah_aksesoris'])) {
  $no = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dijual_hash")) + 1;
  $simpan = mysqli_query($koneksi, "insert into barang_dijual_hash values('','$no','" . $_POST['no_seri'] . "')");
  if ($simpan) {
    echo "<script>window.location='index.php?page=simpan_jual_alkes2'</script>";
  }
}


?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Instalasi &amp; Uji Fungsi</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Instalasi &amp; Uji Fungsi</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success">
          <!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <div class="">
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom">Nama RS/Dinas/Klinik/dll</th>
                        <th valign="bottom">Alamat</th>
                        <th valign="bottom"><strong>Kontak RS/Dinas/dll</strong></th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php
                          $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembeli where id=$_GET[id_rumkit]"));
                          echo $sel['nama_pembeli']; ?></td>
                      <td><?php echo $sel['jalan']; ?></td>
                      <td><?php echo $sel['kontak_rs']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />
                <h3 align="center">
                  Detail Alkes
                </h3>
                <span class="pull pull-right">
                  <table>
                    <tr>
                      <td valign="top"><strong style="color:#F00">Keterangan</strong> : &nbsp;&nbsp;&nbsp;</td>
                      <td valign="top">1. </td>
                      <td valign="top">Jika <strong>Box</strong> Di <strong>Nama Alkes</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                        barang telah dikembalikan karena mengalami kerusakan</td>
                    </tr>
                  </table>
                </span><br /><br /><br />
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>
                <?php include "include/header_pencarian.php"; ?>
                <div class="">
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
                <p align="left">&nbsp;</p>
                <br />

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

<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Instalasi & Uji Fungsi</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id_ubah" id="id_ubah" />

          <label>Soft. Version</label>
          <input name="soft_version" class="form-control" type="text" required placeholder="Soft. Version" id="s_v"><br />
          <label>Tgl Garansi</label>
          <input name="tgl_garansi" class="form-control" type="date" required placeholder="Tgl Garansi" id="tgl_g"><br />
          <label>Tgl Instalasi</label>
          <input name="tgl_i" class="form-control" type="date" required placeholder="Nama Aksesoris" id="t_i"><br />
          <label>Tgl Uji Fungsi</label>
          <input name="tgl_f" class="form-control" type="date" placeholder="Tipe" required id="t_f"><br />
          <label>Keterangan</label>
          <textarea name="keterangan" class="form-control" placeholder="" rows="3" id="ket"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubah_uji" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahinstalasi">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Lampiran Instalasi</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id_i" id="id_i" />
          <input name="lampiran_i" type="file" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubahlampiran1" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahfungsi">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Lampiran Uji Fungsi</h4>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id_f" id="id_f" />
          <input name="lampiran_f" type="file" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubahlampiran2" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function lampiranInstalasi(id) {
    document.getElementById("id_i").value = id;
    $('#modal-ubahinstalasi').modal('show');
  }

  function lampiranUjiFungsi(id) {
    document.getElementById("id_f").value = id;
    $('#modal-ubahfungsi').modal('show');
  }

  function modalUbah(id, s, t_e, t_i, t_f, ket) {
    document.getElementById("id_ubah").value = id;
    document.getElementById("s_v").value = s;
    document.getElementById("tgl_g").value = t_e;
    document.getElementById("t_i").value = t_i;
    document.getElementById("t_f").value = t_f;
    document.getElementById("ket").value = ket;
    $('#modal-ubah').modal('show');
  }

  function hapus(id, id2) {
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
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_hapus=' + id + '&id_rumkit=' + id2;
      }
    })
  }
</script>