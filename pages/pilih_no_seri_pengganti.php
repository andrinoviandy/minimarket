<?php
$nopo = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dikirim where id=" . $_SESSION['no_po'] . ""));
// if (isset($_GET['simpan_barang']) == 1) {

// }


// if (isset($_POST['simpan_tambah_aksesoris'])) {
//   $cek_no_seri = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail_pengganti_hash where id=" . $_POST['barang_dikirim_detail_hash_id'] . ""));
//   if ($cek_no_seri == 0) {
//     $simpan = mysqli_query($koneksi, "insert into barang_dikirim_detail_pengganti_hash values('','" . $_SESSION['id'] . "','" . $_POST['barang_dikirim_detail_id'] . "','" . $_POST['jml_kirim'] . "','" . $_POST['kategori_brg'] . "','" . $_POST['barang_gudang_set_id'] . "','" . $_POST['barang_gudang_satuan_id'] . "','" . $_POST['barang_gudang_akse_id'] . "','" . $_POST['no_seri'] . "')");
//     if ($simpan) {
//       echo "<script>window.location='index.php?page=pilih_no_seri_pengganti'</script>";
//     }
//   } else {
//     $simpan = mysqli_query($koneksi, "update barang_dikirim_detail_pengganti_hash set akun_id='" . $_SESSION['id'] . "',barang_dikirim_detail_id='" . $_POST['barang_dikirim_detail_id'] . "',barang_gudang_detail_id='" . $_POST['no_seri'] . "' where id=" . $_POST['barang_dikirim_detail_hash_id'] . "");
//     if ($simpan) {
//       echo "<script>window.location='index.php?page=pilih_no_seri_pengganti'</script>";
//     }
//   }
//   //}
// }

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengiriman Alkes Pengganti</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Pengiriman Alkes</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <div class="">
                <div class="table-responsive">
                  <table width="100%" id="" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th valign="bottom"><strong>No. PO </strong></th>
                        <th valign="bottom">No Surat Jalan Sebelumnya</th>
                        <th valign="bottom"><strong>Nama Paket</strong></th>
                        <td align="center" valign="bottom"><strong>No. Surat Jalan Baru</strong></td>
                        <td align="center" valign="bottom"><strong>Ekspedisi</strong></td>
                        <td align="center" valign="bottom"><strong>Tanggal Pengiriman</strong></td>
                        <td align="center" valign="bottom"><strong>Via Pengiriman</strong></td>
                        <td align="center" valign="bottom"><strong>Estimasi Brg Sampai</strong></td>
                        <td align="center" valign="bottom"><strong>Biaya Jasa</strong></td>
                        <td align="center" valign="bottom"><strong>Keterangan</strong></td>
                      </tr>
                      <tr>
                        <th valign="bottom"><?php
                                            echo $nopo['no_po_jual']; ?></th>
                        <td valign="bottom"><?php echo $nopo['no_pengiriman'] ?></td>
                        <td valign="bottom"><?php echo $_SESSION['nama_paket']; ?></td>
                        <td align="center" valign="bottom"><?php echo $_SESSION['no_pengiriman']; ?></td>
                        <td align="center" valign="bottom"><?php echo $_SESSION['ekspedisi']; ?></td>
                        <td align="center" valign="bottom"><?php echo date("d-m-Y", strtotime($_SESSION['tgl_pengiriman'])); ?></td>
                        <td align="center" valign="bottom"><?php echo $_SESSION['via_pengiriman']; ?></td>
                        <td align="center" valign="bottom"><?php
                                                            if ($_SESSION['estimasi'] != 0000 - 00 - 00) {
                                                              echo date("d-m-Y", strtotime($_SESSION['estimasi']));
                                                            } ?></td>
                        <td align="center" valign="bottom"><?php echo number_format($_SESSION['biaya_kirim'], 2, ',', '.'); ?></td>
                        <td align="center" valign="bottom"><?php echo $_SESSION['keterangan']; ?></td>
                      </tr>
                    </thead>

                    <script type="text/javascript">
                      <?php
                      echo $jsArray;
                      ?>

                      function changeValue(id_akse) {
                        document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse;
                        document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
                        document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
                        document.getElementById('harga').value = dtBrg[id_akse].harga;
                      };
                    </script>
                    <?php

                    $no = 0;
                    $q_akse = mysqli_query($koneksi, "select *,barang_dijual_detail.id as idd from barang_dijual_detail,barang_gudang_detail,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_dijual_detail.barang_dijual_id=" . $_GET['id'] . "");
                    $jm = mysqli_num_rows($q_akse);
                    if ($jm != 0) {
                      while ($data_akse = mysqli_fetch_array($q_akse)) {
                        $no++;
                    ?>
                    <?php }
                    } ?>
                  </table>
                </div>
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <br /><br />
                <center>
                  <font class="" size="+2">Data Barang Yang Batal</font>
                </center>

                <div class="box box-body">

                  <!--<font color="#FF0000">* Jika Ingin Menambah Data Aksesoris Yang Baru ! Klik Disini <a href="index.php?page=simpan_tambah_aksesoris&id=<?php //echo $_GET['id']; 
                                                                                                                                                            ?>#openAkse"><small data-toggle="tooltip" title="Tambah Aksesoris Baru" class="label bg-blue">+ New Accessories</small></a></font>-->

                  <div class="table-responsive">
                    <div id="data-pengganti"></div>
                  </div>
                </div>
                <center>
                  <!-- <a href="index.php?page=pilih_no_seri_pengganti&simpan_barang=1"> -->
                  <a href="javascript:void()" onclick="simpanBarangPengganti(); return false;">
                    <button name="simpan_barang" class="btn btn-warning" type="button"><span class="fa fa-check"></span> Simpan & Kirim Barang</button></a>&nbsp;&nbsp;<a href="index.php?page=kirim_barang"><button name="simpan_barang" class="btn btn-success" type="button"><span class="fa fa-close"></span> Kembali</button>
                  </a>
                </center>
                <!--
<center><a href="index.php?page=simpan_jual_alkes2&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Simpan</button></a>&nbsp;&nbsp;<a href="index.php?page=jual_barang"><button name="batal" class="btn btn-success" type="submit"><span class="fa  fa-times-circle"></span> Batal</button></a></center>
-->
              </div>
            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">

        <!-- Map box --><!-- /.box -->

        <!-- solid sales graph --><!-- /.box -->

        <!-- Calendar --><!-- /.box -->

      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
<div class="modal fade" id="modal-ubahnoseri">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ganti No Seri</h4>
      </div>
      <form method="post" id="formData" enctype="multipart/form-data" onsubmit="UbahNoSeriPengganti(); return false;">
        <div class="modal-body">
          <div id="ubah_no_seri_pengganti"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning" name="testing2">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
  function simpanBarangPengganti() {
    showLoading(1)
    $.post("data/simpan-barang-pengganti.php",
      function(data, textStatus, jqXHR) {
        showLoading(0)
        if (data === 'S') {
          Swal.fire({
            customClass: {
              confirmButton: 'bg-green',
              cancelButton: 'bg-white',
            },
            title: 'Suksess !',
            text: 'Data Berhasil Disimpan',
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'OK',
            allowOutsideClick: false,
          }).then((result) => {
            if (result.isConfirmed) {
              location.href = 'index.php?page=kirim_barang'
            }
          })
        } else if (data === 'KOSONG') {
          alertCustom('F', 'Gagal !', 'Data Masih Kosong !')
        } else {
          alertSimpan('F')
        }
      }
    );
  }

  function UbahNoSeriPengganti() {
    var dataform = $('#formData')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan_no_seri_pengganti.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getDataPengganti()
          $('#modal-ubahnoseri').modal('hide')
          alertSimpan('S');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function showModal(id) {
    $.get("data/ubah_no_seri_pengganti.php", {
        id: id
      },
      function(data) {
        $('#ubah_no_seri_pengganti').html(data);
        $('#modal-ubahnoseri').modal('show')
      }
    );
  }

  function hapusPengganti(id_hapus) {
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
        $.post("data/hapus_data_pengganti.php", {
            id_hapus: id_hapus
          },
          function(data) {
            if (data == 'S') {
              alertHapus('S');
              getDataPengganti();
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })
  }

  function getDataPengganti() {
    // loading_data('#data-detail-kirim');
    $.get("data/data_barang_pengganti.php", {
        no_po: '<?php echo $_SESSION['no_po']; ?>'
      },
      function(data) {
        $('#data-pengganti').html(data);
      }
    );
  }

  $(document).ready(function() {
    // loading_data('#data-barang');
    getDataPengganti();
  });
</script>