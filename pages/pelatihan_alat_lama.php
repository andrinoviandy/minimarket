<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pelatihan Penggunaan
      Alkes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pelatihan Penggunaan Alkes</li>
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
                      <td valign="top">Jika <strong>Box</strong> Di <strong>No Seri</strong> Berwarna <strong style="color:#F00">Merah</strong> , Itu menandakan<br />
                        barang telah dikembalikan karena mengalami kerusakan</td>
                    </tr>
                  </table>
                </span><br /><br /><br />
                <div>
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
<?php
if (isset($_POST['jual'])) {
  $jml1 = mysqli_fetch_array(mysqli_query($koneksi, "select * from master_barang where id=" . $_GET['id'] . ""));
  if ($_POST['qty'] <= $jml1['stok']) {
    $q = mysqli_query($koneksi, "insert into jual_barang values('','" . $_GET['id'] . "','" . $_POST['pembeli'] . "','" . $_POST['qty'] . "','" . $_POST['tgl_beli'] . "','','','')");
    if ($q) {
      mysqli_query($koneksi, "update master_barang set stok=stok-" . $_POST['qty'] . " where id=" . $_GET['id'] . "");
      echo "<script type='text/javascript'>
		  window.location='index.php?page=jual_barang';
		  </script>";
    }
    //$d = mysqli_fetch_array(mysqli_query($koneksi, "select * from master barang where id=".$_GET['id'].""));
  } else {
    echo "<script type='text/javascript'>
		  alert('Data Stok Kurang !');
		  </script>";
  }
}
?>
<div id="openQuantity" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Jual Barang</h3>
    <form method="post">
      <input id="input" type="date" placeholder="" name="tgl_beli" required>
      <input id="input" type="text" placeholder="Pembeli" name="pembeli" required>
      <input id="input" type="text" placeholder="Quantity" name="qty" required>
      <button id="buttonn" name="jual" type="submit">Jual Barang</button>
    </form>
  </div>
</div>

<div class="modal fade" id="modal-lampiran">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title" align="center"></h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <img id="lampiran" width="100%" height="auto" />
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

<div class="modal fade" id="modal-ubahlamp1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Lampiran 1</h4>
      </div>
      <form id="formData1" onsubmit="simpanLamp1(); return false">
        <div class="modal-body">
          <input type="hidden" name="id_lamp1" id="id_lamp1" />
          <input name="lamp1" type="file" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="simpan_1" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-ubahlamp2">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Lampiran 2</h4>
      </div>
      <form id="formData2" onsubmit="simpanLamp2(); return false">
        <div class="modal-body">
          <input type="hidden" name="id_lamp2" id="id_lamp2" />
          <input name="lamp2" type="file" class="form-control" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="simpan_2" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
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
        $.post("data/hapus-alat-pelatihan.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              alertSimpan('S');
              loadMore(load_flag, key, status_b)
            } else {
              alertSimpan('F');
            }
          }
        );
      }
    })
  }

  function simpanLamp1() {
    var dataform = $('#formData1')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/simpan-lampiran1.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubahlamp1').modal('hide');
          alertSimpan('S');
          loadMore(load_flag, key, status_b)
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function simpanLamp2() {
    var dataform = $('#formData2')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "POST",
      url: "data/simpan-lampiran2.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      cache: false,
      success: function(response) {
        if (response == 'S') {
          $('#modal-ubahlamp2').modal('hide');
          alertSimpan('S');
          loadMore(load_flag, key, status_b)
          dataform.reset();
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function ubahLamp1(id) {
    $('#id_lamp1').val(id);
    $('#modal-ubahlamp1').modal('show');
  }

  function ubahLamp2(id) {
    $('#id_lamp2').val(id);
    $('#modal-ubahlamp2').modal('show');
  }

  function modalLampiran(name, gambar) {
    $('#lampiran').attr('src', gambar);
    $('#title').html(name);
    $('#modal-lampiran').modal('show');
  }
</script>