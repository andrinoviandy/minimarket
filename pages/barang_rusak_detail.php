<?php
if (isset($_POST['ubahuji'])) {
  $u = mysqli_query($koneksi, "update barang_gudang_detail_rusak set teknisi_id='" . $_POST['id_teknisi'] . "' where id=$_POST[id_brg]");
  if ($u) {
    echo "<script>
    Swal.fire({
      customClass: {
        confirmButton: 'bg-green',
        cancelButton: 'bg-white',
      },
      title: 'Data Berhasil Disimpan ',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(()=> {
      window.location.href = '?page=barang_rusak_detail&id_gudang=$_GET[id_gudang]';
    })
    </script>";
  }
}

if (isset($_GET['id_hapus'])) {
  $se = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang_detail_rusak where id=$_GET[id_hapus]"));
  $up = mysqli_query($koneksi, "update barang_gudang_detail set status_kerusakan=0 where id=" . $se['barang_gudang_detail_id'] . "");
  $up2 = mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set barang_gudang.stok_total=barang_gudang.stok_total+1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $se['barang_gudang_detail_id'] . "");
  $h = mysqli_query($koneksi, "delete from barang_gudang_detail_rusak where id=$_GET[id_hapus]");
  if ($up and $up2 and $h) {
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
      window.location.href = '?page=barang_rusak_detail&id_gudang=$_GET[id_gudang]';
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
    }),then(()=> {
      window.location.href = '?page=barang_rusak_detail&id_gudang=$_GET[id_gudang]';
    })
    </script>";
  }
}

if (isset($_POST['tambah_laporan'])) {
  $Result = mysqli_query($koneksi, "insert into alat_uji_detail values('','" . $_POST['id_akse'] . "','" . $_POST['soft_version'] . "','" . $_POST['tgl_garansi_habis'] . "','" . $_POST['tgl_i'] . "','" . $_POST['lampiran_i'] . "','" . $_POST['tgl_f'] . "','" . $_POST['lampiran_f'] . "','" . $_POST['keterangan'] . "')");
  if ($Result) {
    mysqli_query($koneksi, "update barang_teknisi_detail set status_uji=1 where id=" . $_POST['id_akse'] . "");
    echo "<script type='text/javascript'>
		alert('Data Berhasil Di Simpan !');
		window.location='index.php?page=simpan_tambah_uji&id=$_GET[id]';
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
    echo "<script type='text/javascript'>
	alert('Data Berhasil Di Simpan !');
	window.location='index.php?page=jual_barang'</script>";
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
    <h1>Detail Barang Rusak</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Detail Barang Rusak</li>
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
                  <table width="100%" id="" class="table table-bordered">
                    <thead>
                      <tr>
                        <th valign="bottom">Nama Alkes</th>
                        <th valign="bottom">Tipe</th>
                        <th valign="bottom"><strong>Merk</strong></th>
                        <th valign="bottom">Negara Asal</th>
                        <th valign="bottom">Deskripsi alat</th>
                      </tr>
                    </thead>
                    <tr>
                      <td><?php
                          $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_gudang where id=$_GET[id_gudang]"));
                          echo $sel['nama_brg']; ?></td>
                      <td><?php echo $sel['tipe_brg']; ?></td>
                      <td><?php echo $sel['merk_brg']; ?></td>
                      <td><?php echo $sel['negara_asal']; ?></td>
                      <td><?php echo $sel['deksripsi_alat']; ?></td>
                    </tr>
                  </table>
                </div>
                <br />
                <h3 align="center">
                  Detail Alkes
                </h3>
                <div class="pull pull-right">
                  <?php //include "include/getFilter.php"; 
                  ?>
                  <?php include "include/atur_halaman.php"; ?>
                </div>

                <?php include "include/header_pencarian.php"; ?>
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

<div class="modal fade" id="modal-teknisi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Pilih Teknisi</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <p align="justify">
            <input type="hidden" name="id_brg" id="id_brg" />
            <select name="id_teknisi" id="id_teknisi" class="form-control select2" style="width:100%">
              <option value="">...</option>
              <?php
              $query_teknisi = mysqli_query($koneksi, "select * from tb_teknisi order by nama_teknisi ASC");
              while ($data_t = mysqli_fetch_array($query_teknisi)) {
              ?>
                <option <?php if ($json[$i]['teknisi_id'] == $data_t['id']) {
                          echo "selected";
                        } ?> value="<?php echo $data_t['id']; ?>"><?php echo $data_t['nama_teknisi'] . " - " . $data_t['bidang']; ?></option>
              <?php } ?>
            </select>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubahuji" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function pilihTeknisi(id, id_teknisi) {
    document.getElementById("id_brg").value = id
    document.getElementById("id_teknisi").value = id_teknisi;
    $('#modal-teknisi').modal('show');
  }

  function hapus(id_gudang, id_hapus) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Data Ini ?',
      text: 'Aksi Ini Akan Membuat History Kerusakan Alkes Akan Terhapus Dan Status Alkes Menjadi Layak Untuk Dijual',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '?page=' + getVars("page").replace('#', '') + '&id_gudang=' + id_gudang + '&id_hapus=' + id_hapus;
      }
    })
  }
</script>