<?php
if (isset($_GET['simpan_barang']) == 1) {
  $cek4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pinjam_detail_hash where akun_id=" . $_SESSION['id'] . ""));
  if ($cek4 != 0) {
    $s1 = mysqli_query($koneksi, "insert into barang_pinjam values('','" . $_SESSION['barang_dikirim_id'] . "','" . $_SESSION['tgl'] . "','" . $_SESSION['kegiatan'] . "','" . $_SESSION['estimasi'] . "')");
    if ($s1) {
      $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from barang_pinjam"));
      $q = mysqli_query($koneksi, "select * from barang_pinjam_detail_hash where akun_id=" . $_SESSION['id'] . "");
      while ($d = mysqli_fetch_array($q)) {
        $s = mysqli_query($koneksi, "insert into barang_pinjam_detail values('','" . $max['id_max'] . "','" . $d['barang_gudang_detail_id'] . "','0')");
      }
      if ($s1 and $s) {
        mysqli_query($koneksi, "delete from barang_pinjam_detail_hash where akun_id=" . $_SESSION['id'] . "");
        echo "<script>
		alert('Berhasil Disimpan !');
		window.location='index.php?page=peminjaman_barang'</script>";
      }
    } else {
      echo "<script>
		alert('Gagal Disimpan ! Hindari Penggunaan Tanda Petik (')');
		window.location='index.php?page=tambah_peminjaman_barang'</script>";
    }
  } else {
    echo "<script>
		alert('Data Belum Diisi !');
		window.location='index.php?page=peminjaman_barang'</script>";
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Peminjaman Barang</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Peminjaman Barang</li>
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
                        <th valign="bottom"><strong>Tanggal Peminjaman</strong></th>
                        <th valign="bottom"><strong>Kegiatan</strong></th>
                        <td align="center" valign="bottom"><strong>RS/Dinas/Dll</strong></td>
                        <td align="center" valign="bottom"><strong>No Surat Jalan</strong></td>
                        <td align="center" valign="bottom"><strong>No. PO</strong></td>
                        <td align="center" valign="bottom"><strong>Estimasi Pengembalian</strong></td>
                      </tr>
                      <tr>
                        <td valign="bottom"><?php echo date("d-m-Y", strtotime($_SESSION['tgl'])); ?></td>
                        <td valign="bottom"><?php echo $_SESSION['kegiatan']; ?></td>
                        <td align="center" valign="bottom"><?php
                                                            $dt = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dikirim.id as idd from barang_dikirim,barang_dikirim_detail,barang_dijual,pembeli,barang_gudang,barang_gudang_detail where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and pembeli.id=barang_dijual.pembeli_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_dikirim_id=" . $_SESSION['barang_dikirim_id'] . ""));
                                                            echo $dt['nama_pembeli']; ?></td>
                        <td align="center" valign="bottom"><?php echo $dt['no_pengiriman']; ?></td>
                        <td align="center" valign="bottom"><?php echo $dt['no_po_jual']; ?></td>
                        <td align="center" valign="bottom"><?php
                                                            if ($_SESSION['estimasi'] != 0000 - 00 - 00) {
                                                              echo date("d-m-Y", strtotime($_SESSION['estimasi']));
                                                            } ?></td>
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
                    <?php
                      }
                    }
                    ?>
                  </table>
                </div>
                <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                <br /><br />
                <center>
                  <font class="" size="+2">
                    Pilih No Seri
                  </font>
                </center>

                <div class="box box-body">
                  <button name="tambah_laporan" class="btn btn-success pull pull-left pull-top" type="button" data-toggle="modal" data-target="#modal-pilihnoseri" onclick="tambahAlkes();"><span class="fa fa-plus"></span> Pilih Barang </button>
                  <br /><br /><br />
                  <div class="table-responsive">
                    <div id="tabel-data"></div>
                  </div>
                </div>
                <center><a href="index.php?page=pilih_peminjaman_barang&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="button"><span class="fa fa-check"></span> Simpan</button></a></center>
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

<div class="modal fade" id="modal-pilihnoseri">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Pilih/Tambah No Seri</h4>
      </div>
      <div id="modal-noseri"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function getData() {
    $.get("data/tabel-noseri-peminjaman-barang.php",
      function(data) {
        $('#tabel-data').html(data);
      }
    );
  }

  function simpanAlkes() {
    $.post("data/simpan-noseri-peminjaman-barang.php", {
        id_akse: $('#id_akse').val(),
        no_seri: $('#no_seri').val(),
        merk_akse: $('#merk_akse').val()
      },
      function(data) {
        if (data == 'S') {
          $('#modal-pilihnoseri').modal('hide');
          getData();
          alertSimpan('S');
        } else if (data == 'SA') {
          $('#modal-pilihnoseri').modal('hide');
          alertCustom('W', 'Gagal !', 'No Seri Sudah Ditambahkan')
        } else {
          alertSimpan('F');
        }
      }
    );
  }

  function tambahAlkes() {
    $.get("data/modal-noseri-peminjaman-barang.php",
      function(data) {
        $('#modal-noseri').html(data);
      }
    );
  }

  function hapusAlkes(id) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Item Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-tabel-noseri-peminjaman-barang.php", {
            id_hapus: id
          },
          function(data) {
            if (data == 'S') {
              getData();
              alertHapus('S');
            } else {
              alertHapus('F');
            }
          }
        );
      }
    })

  }

  $(document).ready(function() {
    getData()
  });
</script>