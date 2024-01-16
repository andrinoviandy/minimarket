<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang.id as idd from utang_piutang where id=$_GET[id]"));
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><span class="active">Bayar Hutang</span></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Hutang</li>
      <li class="active">Bayar Hutang</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) --><!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <section class="col-lg-3 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-body">
              <a href="index.php?page=utang"><button name="tambah_header" class="btn btn-success" type="button"> Kembali</button></a>
              <center>
                <h3 class="box-title">Pembayaran</h3>
              </center>
              <script type="text/javascript">
                function yesnoCheck() {
                  if (document.getElementById('yesCheck').checked) {
                    document.getElementById('ifYes').style.display = 'block';
                  } else document.getElementById('ifYes').style.display = 'none';
                }
              </script>
              <form method="post" id="formData" enctype="multipart/form-data" onsubmit="tambahPembayaran(); return false;">
                <input name="id" value="<?php echo $_GET['id']; ?>" type="hidden">
                <label>Tanggal</label>
                <input name="tgl_input" class="form-control" type="date" placeholder="" required="required" value="<?php echo date('Y-m-d'); ?>"><br />
                <?php
                if ($data['jatuh_tempo'] == 0000 - 00 - 00) {
                  $ac = "checked";
                  $n = "none";
                } else {
                  $ac2 = "checked";
                  $n = "";
                }
                ?>

                <label>Nominal</label>
                <input name="nominal" class="form-control" type="text" placeholder="" required="required" value="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br />
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required="required"></textarea>
                <br />

                <label>Buku Kas</label>
                <select name="akun" id="akun" class="form-control select2" required style="width:100%">
                  <option value="">-- Pilih --</option>
                  <?php
                  $q = mysqli_query($koneksi, "select * from buku_kas order by no_akun ASC");
                  while ($d = mysqli_fetch_array($q)) {
                  ?>
                    <option value="<?php echo $d['id']; ?>"><?php echo $d['no_akun'] . " | &nbsp;&nbsp;" . $d['nama_akun']; ?></option>
                  <?php } ?>
                </select><br /><br />
                <button name="tambah_header" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
              </form>

            </div>
          </div>
        </div>
        <!-- /.box (chat box) -->

        <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget -->
      </section>
      <!-- Left col -->
      <section class="col-lg-9 connectedSortable">
        <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

        <!-- Chat box -->
        <div class="box box-success"><!-- /.chat -->
          <div class="box-footer">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Hutang</h3>
            </div>
            <div class="box-body">
              <div id="header-hutang"></div>
              <h4 class="box-title" align="center">Riwayat Pembayaran</h4>
              <div class="table-responsive">
                <div id="riwayat-pembayaran"></div>
              </div>
              <script type="text/javascript">
                function yesnoCheck() {
                  if (document.getElementById('yesCheck').checked) {
                    document.getElementById('ifYes').style.display = 'block';
                  } else document.getElementById('ifYes').style.display = 'none';
                }
              </script><br /><br />
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

<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.chained.min.js"></script>
<script>
  $("#jenis_akun").chained("#akun");
  $("#jenis_akun2").chained("#akun2");
</script>

<div class="modal fade" id="modal-detailhutang<?php echo $data['idd']; ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Barang</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <p align="justify">

            <?php
            $q2 = mysqli_query($koneksi, "select nama_brg,tipe_brg,qty,status_ke_stok from barang_pesan_detail,barang_gudang,barang_pesan where barang_gudang.id=barang_pesan_detail.barang_gudang_id and barang_pesan.id=barang_pesan_detail.barang_pesan_id and barang_pesan.no_po_pesan='" . $data['no_faktur_no_po'] . "'");
            $n = 0;
            while ($d1 = mysqli_fetch_array($q2)) {
              $n++;
            ?>
              <?php echo $n . ". " . $d1['nama_brg'] . "     |    "; ?></td>
              <?php echo $d1['tipe_brg'] . "  |  " ?></td>
              <?php echo $d1['qty']; ?>
              <hr />
            <?php } ?>

          </p>
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

<div class="modal fade" id="modal-detail<?php echo $data['idd']; ?>">
  <div class="modal-header">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Detail Hutang</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

            <!-- Chat box -->
            <div class="box box-warning"><!-- /.chat -->
              <div class="box-footer">
                <div class="box-body table-responsive no-padding">
                  <div class="">
                    <!--<a href="index.php?page=tambah_barang_masuk"><button name="tambah_laporan" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah Barang</button></a>-->
                    <div class="table-responsive no-padding">
                      <?php
                      $dataa = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_pesan.id as idd from barang_pesan,principle,mata_uang where mata_uang.id=barang_pesan.mata_uang_id and principle.id=barang_pesan.principle_id and no_po_pesan='" . $data['no_faktur_no_po'] . "'"));
                      ?>
                      <table width="100%" id="" class="table table-bordered text-nowrap">
                        <thead>
                          <tr>
                            <th valign="bottom"><strong>Tgl PO</strong></th>
                            <th valign="bottom">No. PO</th>
                            <th valign="bottom"><strong>Nama_Principle</strong></th>
                            <th valign="bottom">Alamat_Principle</th>
                            <th valign="bottom"><strong>PPN</strong></th>
                            <th valign="bottom"><strong>Cara_Pembayaran</strong></th>
                            <th valign="bottom">Alamat_Pengiriman</th>
                            <th valign="bottom">Jalur_Pengiriman</th>
                            <th valign="bottom">Estimasi_Pengiriman</th>
                            <th valign="bottom">Catatan</th>
                          </tr>
                        </thead>
                        <tr>
                          <td><?php echo date("d F Y", strtotime($dataa['tgl_po_pesan'])); ?>
                          </td>
                          <td><?php echo $dataa['no_po_pesan']; ?></td>
                          <td><?php echo $dataa['nama_principle']; ?></td>
                          <td><?php echo str_replace("\n", "<br>", $dataa['alamat_principle']); ?></td>
                          <td><?php echo $dataa['ppn'] . " %"; ?></td>
                          <td><?php echo $dataa['cara_pembayaran']; ?></td>
                          <td><?php echo str_replace("\n", "<br>", $dataa['alamat_pengiriman']); ?></td>
                          <td><?php echo $dataa['jalur_pengiriman']; ?></td>
                          <td><?php
                              if ($dataa['estimasi_pengiriman'] == 0000 - 00 - 00) {
                                echo "-";
                              } else {
                                echo date("d F Y", strtotime($dataa['estimasi_pengiriman']));
                              } ?></td>
                          <td><?php echo $dataa['catatan']; ?></td>
                        </tr>
                      </table>
                    </div>
                    <br /><br />
                    <table width="100%" id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td valign="bottom"><strong>No</strong></td>
                          <td valign="bottom"><strong>Nama Alkes</strong></td>
                          <td align="center" valign="bottom"><strong>Tipe
                            </strong></td>
                          <td align="center" valign="bottom"><strong>Merk
                            </strong></td>
                          <td align="center" valign="bottom"><strong>Qty</strong></td>
                          <td align="center" valign="bottom"><strong>Mata Uang
                            </strong></td>
                          <td align="center" valign="bottom"><strong>Harga Per Unit </strong></td>
                          <td align="center" valign="bottom"><strong>Diskon (%)</strong></td>
                          <td align="center" valign="bottom"><strong>Total Harga
                            </strong></td>
                          <td align="center" valign="bottom"><strong>Catatan Spek</strong></td>

                        </tr>
                      </thead>


                      <?php

                      $no = 0;
                      $q_akse = mysqli_query($koneksi, "select *,barang_pesan_detail.id as idd,barang_gudang.id as id_gudang from barang_pesan_detail,barang_gudang,mata_uang where barang_gudang.id=barang_pesan_detail.barang_gudang_id and mata_uang.id=barang_pesan_detail.mata_uang_id and barang_pesan_detail.barang_pesan_id=$dataa[idd]");
                      $jm = mysqli_num_rows($q_akse);
                      if ($jm != 0) {
                        while ($data_akse = mysqli_fetch_array($q_akse)) {
                          $no++;
                      ?>
                          <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data_akse['nama_brg']; ?>
                            </td>
                            <td align="center"><?php echo $data_akse['tipe_brg']; ?></td>
                            <td align="center"><?php echo $data_akse['merk_brg']; ?></td>
                            <td align="center"><?php echo $data_akse['qty']; ?></td>
                            <td align="center"><?php echo $data_akse['jenis_mu']; ?></td>
                            <td align="center"><?php echo $data_akse['simbol'] . " " . number_format($data_akse['harga_perunit'], 2, ',', '.'); ?></td>
                            <td align="center"><?php
                                                if ($data_akse['diskon'] != 0) {
                                                  echo $data_akse['diskon'] . " %";
                                                } else {
                                                  echo "0 %";
                                                } ?></td>
                            <td align="right"><?php echo $data_akse['simbol'] . " " . number_format($data_akse['harga_total'], 2, ',', '.'); ?></td>
                            <td align="center"><?php echo $data_akse['catatan_spek']; ?></td>

                          </tr>

                      <?php }
                      } ?>

                      <tr>
                        <td colspan="8" align="right" valign="bottom"><strong>Total Price =</strong></td>
                        <td align="right">
                          <?php
                          $total = mysqli_fetch_array(mysqli_query($koneksi, "select *,sum(harga_total) as total from barang_pesan_detail where barang_pesan_id=$dataa[idd]"));
                          //$total = mysqli_query($koneksi, "select * from barang_pesan_detail where barang_pesan_id=$id");
                          //echo " ".number_format($total_akse2+$total['total'],0,',',',').".00";
                          ?>
                          <?php echo $dataa['simbol'] . " " . number_format($total['total'], 2, ',', '.'); ?>

                        </td>
                        <td></td>
                      </tr>
                      <tr>
                        <td colspan="8" align="right" valign="bottom"><strong>Total Price + PPN(<?php echo $dataa['ppn'] . "%"; ?>) =</strong></td>
                        <td align="right">
                          <?php echo $dataa['simbol'] . " " . number_format(($total['total']) + (($total['total']) * floatval($data['ppn']) / 100), 2, ',', '.'); ?>

                        </td>
                        <td></td>
                      </tr>
                      <tr>
                        <td colspan="8" align="right" valign="bottom"><strong>Freight Cost by Air to JAKARTA =</strong></td>
                        <td align="right" valign="top"><?php
                                                        if ($dataa['cost_byair'] != 0) {
                                                          echo $dataa['simbol'] . " " . number_format($dataa['cost_byair'], 2, ',', '.');
                                                        } else {
                                                          echo $dataa['simbol'] . " " . "0";
                                                        } ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td height="24" colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan =</strong></td>
                        <td align="right" valign="top"><?php echo $dataa['simbol'] . " " . number_format($dataa['cost_cf'], 2, ',', '.'); ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td height="24" colspan="8" align="right" valign="bottom">Nilai Tukar (satuan dalam rupiah) =</td>
                        <td align="right" valign="top"><?php if ($dataa['nilai_tukar'] != 0) {
                                                          echo number_format($dataa['nilai_tukar'], 2, ',', '.');
                                                        } else {
                                                          echo "1";
                                                        } ?></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td height="24" colspan="8" align="right" valign="bottom"><strong>Total Keseluruhan</strong> (Rupiah) =</td>
                        <td align="right" valign="top"><?php
                                                        $mu = mysqli_fetch_array(mysqli_query($koneksi, " select * from utang_piutang where no_faktur_no_po='" . $dataa['no_po_pesan'] . "'"));
                                                        if ($mu['nominal'] != 0) {
                                                          $total_rupiah = $mu['nominal'];
                                                        }
                                                        ?>
                          <?php echo "Rp " . number_format($total_rupiah, 2, ',', '.'); ?></td>
                        <td></td>
                      </tr>
                    </table>
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

          <!-- right col -->
        </div>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-warning" data-dismiss="modal">Close</button></center>

      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalUbah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center">Ubah Pembayaran</h4>
      </div>
      <form method="post" onsubmit="ubahPembayaran(); return false;" id="formUbah">
        <div class="modal-body">
          <div id="modal-ubah"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button name="ubah_riwayat" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function loading() {
    $.get("include/getLoading.php", function(data) {
      $('#riwayat-pembayaran').html(data);
    });
  }

  function modalUbah(id, id_ubah) {
    $('#modalUbah').modal('show');
    $.get("data/modal-ubah-hutang.php", {
        id: id,
        id_ubah: id_ubah
      },
      function(data) {
        $('#modal-ubah').html(data);
      }
    );
  }

  function getHeader() {
    $.get("data/header-hutang.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#header-hutang').html(data);
      }
    );
  }

  function getRiwayat() {
    loading();
    $.get("data/riwayat-pembayaran-hutang.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#riwayat-pembayaran').html(data);
      }
    );
  }

  function ubahPembayaran() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/ubah-pembayaran-hutang.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          $('#modalUbah').modal('hide');
          dataform.reset();
          getRiwayat();
          getHeader();
          alertSimpan('S')
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  function hapus(id_hapus) {
    Swal.fire({
      customClass: {
        confirmButton: 'bg-red',
        cancelButton: 'bg-white',
      },
      title: 'Anda Yakin Akan Menghapus Transaksi Ini ?',
      text: 'Data Akan Dihapus Secara Permanen',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya , Hapus',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("data/hapus-pembayaran-hutang.php", {
            id: '<?php echo $_GET['id'] ?>',
            id_hapus: id_hapus
          },
          function(data) {
            if (data == 'S') {
              getRiwayat();
              getHeader();
              alertHapus('S')
            } else {
              alertHapus('F')
            }
          }
        );
      }
    })
  }

  function tambahPembayaran() {
    var dataform = $('#formData')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-pembayaran-hutang.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
          dataform.reset();
          getRiwayat();
          getHeader();
          alertSimpan('S');
        } else if (response == 'TC') {
          alertCustom('W', 'Gagal Disimpan !', 'Saldo Pada Buku Kas Ini Kurang Dari Nominal Yang Di Masukkan ! Silakan Tambah Saldo Atau Gunakan Buku Kas Lain !');
        } else {
          alertSimpan('F')
        }
      }
    });
  }

  $(document).ready(function() {
    getHeader();
    getRiwayat();
  });
</script>