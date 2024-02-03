<?php
if (isset($_GET['simpan_barang']) == 1) {
  $cek4 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail_hash where akun_id=" . $_SESSION['id'] . ""));
  if ($cek4 != 0) {
    $s1 = mysqli_query($koneksi, "insert into barang_demo_kirim values('','" . $_SESSION['nama_paket'] . "','" . $_SESSION['no_pengiriman'] . "','" . $_SESSION['tgl_pengiriman'] . "','" . $_SESSION['no_po'] . "','" . $_SESSION['ekspedisi'] . "','" . $_SESSION['via_pengiriman'] . "','" . $_SESSION['estimasi'] . "','" . $_SESSION['biaya_kirim'] . "','','" . $_SESSION['keterangan'] . "')");

    $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from barang_demo_kirim"));
    $q = mysqli_query($koneksi, "select * from barang_demo_kirim_detail_hash where akun_id=" . $_SESSION['id'] . "");
    while ($d = mysqli_fetch_array($q)) {
      $s = mysqli_query($koneksi, "insert into barang_demo_kirim_detail values('','" . $max['id_max'] . "','" . $d['barang_demo_qty_id'] . "','" . $d['barang_gudang_detail_id'] . "','')");
      $up_stok = mysqli_query($koneksi, "update barang_gudang,barang_gudang_detail set stok_total=stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $d['barang_gudang_detail_id'] . "");
      $up_status = mysqli_query($koneksi, "update barang_gudang_detail set status_demo=1 where id=" . $d['barang_gudang_detail_id'] . "");
    }
    if ($s1 and $s and $up_status and $up_stok) {
      //$Result = mysqli_query($koneksi, "insert into utang_piutang values('','Hutang','".$_SESSION['no_po']."','".$_POST['tgl_input']."','".$_POST['jatuh_tempo']."','".$_POST['nominal']."','".$_POST['klien']."','".$_POST['deskripsi']."','0')");
      mysqli_query($koneksi, "delete from barang_demo_kirim_detail_hash where akun_id=" . $_SESSION['id'] . "");
      echo "<script>
		alert('Berhasil disimpan !');
		window.location='index.php?page=kirim_barang_demo'</script>";
    }
  } else {
    echo "<script>
		alert('Data Belum Diisi !');
		window.location='index.php?page=pilih_no_seri_demo&id=$_GET[id]'</script>";
  }
}

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pengiriman Barang Demo</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Pengiriman Barang Demo</li>
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
                <table width="100%" id="" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th valign="bottom"><strong>Nama Paket</strong></th>
                      <td align="center" valign="bottom"><strong>No. Surat Jalan</strong></td>
                      <td align="center" valign="bottom"><strong>Ekspedisi</strong></td>
                      <td align="center" valign="bottom"><strong>Tanggal Pengiriman</strong></td>
                      <td align="center" valign="bottom"><strong>Via Pengiriman</strong></td>
                      <td align="center" valign="bottom"><strong>Estimasi Brg Sampai</strong></td>
                      <td align="center" valign="bottom"><strong>Biaya Jasa</strong></td>
                      <td align="center" valign="bottom"><strong>Keterangan</strong></td>
                    </tr>
                    <tr>
                      <th valign="bottom"><?php echo $_SESSION['nama_paket']; ?></th>
                      <td align="center" valign="bottom"><?php echo $_SESSION['no_pengiriman']; ?></td>
                      <td align="center" valign="bottom"><?php echo $_SESSION['ekspedisi']; ?></td>
                      <td align="center" valign="bottom"><?php echo date("d-m-Y", strtotime($_SESSION['tgl_pengiriman'])); ?></td>
                      <td align="center" valign="bottom"><?php echo $_SESSION['via_pengiriman']; ?></td>
                      <td align="center" valign="bottom"><?php
                                                          if ($_SESSION['estimasi'] != 0000 - 00 - 00) {
                                                            echo date("d-m-Y", strtotime($_SESSION['estimasi']));
                                                          } ?></td>
                      <td align="center" valign="bottom"><?php echo number_format($_SESSION['biaya_kirim'], 2, ',', '.'); ?></td>
                      <td align="left" valign="bottom"><?php echo $_SESSION['keterangan']; ?></td>
                    </tr>
                  </thead>
                </table>


                <center>
                  <font class="" size="+1">Pilih No Seri Yang Akan Dikirim</font>
                </center>
                <div class="box box-body">
                  <font class="pull-right" color="#FF0000"><?php
                                                            $qty = mysqli_query($koneksi, "select *,barang_demo_qty.id as id_qty from barang_demo_qty,barang_gudang where barang_gudang.id=barang_demo_qty.barang_gudang_id and barang_demo_id=" . $_GET['id'] . "");
                                                            while ($d_qty = mysqli_fetch_array($qty)) {
                                                              $sel = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_demo_kirim_detail where barang_demo_qty_id=" . $d_qty['id_qty'] . ""));
                                                              echo "Kuantitas : " . $d_qty['nama_brg'] . " (" . ($d_qty['qty'] - $sel) . ")<br>";
                                                            }

                                                            ?></font>
                  <br />
                  <button name="tambah_laporan" class="btn btn-success pull pull-left" type="button" data-toggle="modal" data-target="#modal-pilihnoseri"><span class="fa fa-plus"></span> Pilih/Tambah No Seri </button>
                  <br /><br />
                  <div class="table-responsive no-padding">
                    <div id="tabel-barang-demo"></div>
                    <br>
                    <center><a href="index.php?page=pilih_no_seri_demo&id=<?php echo $_GET['id']; ?>&simpan_barang=1"><button name="simpan_barang" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan</button></a></center>
                  </div>
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
      <div id="modal-noseri-demo"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function getData() {
    $.get("data/tabel-noseri-demo.php",
      function (data) {
       $('#tabel-barang-demo').html(data); 
      }
    );
  }

  function simpanAlkes() {
    $.post("data/simpan-noseri-demo.php", {
        id_akse: $('#id_akse').val(),
        no_seri: $('#no_seri').val(),
        merk_akse: $('#merk_akse').val()
      },
      function(data) {
        if (data == 'S') {
          $('#modal-pilihnoseri').modal('hide');
          getData();
          alertSimpan('S');
        } 
        else if (data == 'G') {
          $('#modal-pilihnoseri').modal('hide');
          alertCustom('W','Gagal !','Sudah Mencukupi Kuantitas')
        }
        else {
          alertSimpan('F');
        }
      }
    );
  }

  function tambahAlkes() {
    $.get("data/modal-noseri-demo.php", {
      id: <?php echo $_GET['id']; ?>
    },
      function (data) {
       $('#modal-noseri-demo').html(data); 
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
        $.post("data/hapus-tabel-noseri-demo.php", {
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

  $(document).ready(function () {
    getData();
    tambahAlkes();
  });
</script>