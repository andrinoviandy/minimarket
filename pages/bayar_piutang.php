<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang.id as idd from utang_piutang where utang_piutang.id=$_GET[id]"));
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><span class="active">Piutang Dibayar</span></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Piutang</li>
      <li class="active">Piutang Dibayar</li>
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
              <a href="index.php?page=piutang"><button name="tambah_header" class="btn btn-success" type="button"> Kembali </button></a>
              <center>
                <h4 class="box-title">Pembayaran</h4>
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

                <label>Akun</label>
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
              <h3 class="box-title">Detail Piutang</h3>
            </div>
            <div class="box-body">
              <div id="header-piutang"></div>
              <h4 class="box-title" align="center">Riwayat Pembayaran</h4>
              <div id="riwayat-pembayaran"></div>
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
<?php

?>
<!-- <div id="openUbah" class="modalDialog">
  <div>
    <a href="#" title="Close" class="close">X</a>
    <h3 align="center">Ubah Riwayat Pembayaran</h3>

    <form method="post">
      <label>Tanggal</label>
      <input name="tgl_input2" class="form-control" type="date" placeholder="" required="required" value="<?php echo $da['tgl_bayar']; ?>"><br />
      <label>Nominal</label>
      <input name="nominal2" class="form-control" type="text" placeholder="" required="required" value="<?php echo $da['nominal']; ?>"><br />
      <label>Deskripsi</label>
      <textarea name="deskripsi2" class="form-control" rows="4" required="required"><?php echo $da['deskripsi']; ?></textarea>
      <br />

      <label>Akun</label>
      <select name="akun2" id="akun2" class="form-control" required>
        <option value="">-- Pilih --</option>
        <?php
        $q = mysqli_query($koneksi, "select * from buku_kas order by no_akun ASC");
        while ($d = mysqli_fetch_array($q)) {
        ?>
          <option <?php if ($da['id_coa'] == $d['id']) {
                    echo "selected";
                  } ?> value="<?php echo $d['id']; ?>"><?php echo $d['no_akun'] . " | &nbsp;&nbsp;" . $d['nama_akun']; ?></option>
        <?php } ?>
      </select><br />

      <button name="ubah_riwayat" class="btn btn-success" type="submit"><span class="fa fa-check"></span> Simpan </button>
    </form>

  </div>
</div> -->
<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.chained.min.js"></script>
<script>
  $("#jenis_akun").chained("#akun");
  $("#jenis_akun2").chained("#akun2");
</script>

<div class="modal fade" id="modal-detailpiutang<?php echo $data['idd']; ?>">
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
            $q2 = mysqli_query($koneksi, "select *,barang_dijual_qty.id as id_det_jual from barang_dijual_qty,barang_dijual,barang_gudang where barang_dijual.id=barang_dijual_qty.barang_dijual_id and barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.no_po_jual='" . $data['no_faktur_no_po'] . "' and status_deal=1");
            $n = 0;
            while ($d1 = mysqli_fetch_array($q2)) {
              $n++;
            ?>
              <?php echo $n . ". " . $d1['nama_brg'] . "     |    "; ?></td>
              <?php echo $d1['tipe_brg'] . "  |  " ?></td>
              <?php echo $d1['qty_jual']; ?>
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
        <h4 class="modal-title" align="center">Detail Piutang</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)--><!-- /.nav-tabs-custom -->

            <!-- Chat box -->
            <div class="box box-warning"><!-- /.chat -->
              <div class="box-footer">
                <div class="box-body">
                  <div class="">
                    <div class="table-responsive">
                      <?php
                      $dataa = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dijual.id as idd from barang_dijual,pembeli,pemakai where pembeli.id=barang_dijual.pembeli_id and pemakai.id=barang_dijual.pemakai_id and no_po_jual='" . $data['no_faktur_no_po'] . "' and status_deal=1"));
                      ?>
                      <table width="100%" id="" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th colspan="7" align="left">
                              <table width="">
                                <tr valign="top">
                                  <td><strong>Marketing </strong></td>
                                  <td><strong>&nbsp;:&nbsp;</strong></td>
                                  <td><strong><?php echo $dataa['marketing']; ?></strong></td>
                                  <td><strong> &nbsp;&nbsp;,&nbsp;&nbsp; </strong></td>
                                  <td><strong>Sub Distributor </strong></td>
                                  <td><strong> &nbsp;:&nbsp; </strong></td>
                                  <td><strong><?php echo $dataa['subdis']; ?></strong></td>
                                  <td><strong>
                                      <!--&nbsp;&nbsp;&nbsp;&nbsp; , Diskon : <?php echo $_SESSION['diskon'] . " %"; ?>&nbsp;&nbsp;&nbsp;&nbsp; , PPN : <?php echo $_SESSION['ppn'] . " %"; ?>-->
                                    </strong></td>
                                </tr>
                              </table>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="4" valign="bottom">&nbsp;</th>
                            <th valign="bottom">&nbsp;</th>
                            <th valign="bottom">&nbsp;</th>
                            <th valign="bottom">&nbsp;</th>

                          </tr>
                          <tr>
                            <th valign="bottom"><strong>Tgl Jual</strong></th>
                            <th valign="bottom">No PO</th>
                            <th valign="bottom">No Kontrak</th>
                            <th valign="bottom">Nama RS/Dinas/Klinik/dll</th>
                            <th valign="bottom"><strong>Kelurahan</strong></th>
                            <th valign="bottom">Alamat</th>
                            <th valign="bottom"><strong>Kontak RS/Dinas/dll</strong></th>

                          </tr>
                        </thead>
                        <tr>
                          <td>
                            <?php echo $dataa['tgl_jual']; ?></td>
                          <td>
                            <?php echo $dataa['no_po_jual']; ?></td>
                          <td><?php echo $dataa['no_kontrak']; ?></td>
                          <td><?php
                              $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from pembeli where id=" . $dataa['pembeli_id'] . ""));
                              echo $sel['nama_pembeli']; ?></td>
                          <td><?php echo $sel['kelurahan_id']; ?></td>
                          <td><?php echo $sel['jalan']; ?></td>
                          <td><?php echo $sel['kontak_rs']; ?></td>

                        </tr>
                      </table>
                    </div>
                    <br />
                    <div class="table-responsive">
                      <table width="100%" class="table table-bordered table-hover">
                        <tr>
                          <td><strong>Nama Pemakai</strong></td>
                          <td><strong>Kontak 1</strong></td>
                          <td><strong>Kontak 2</strong></td>
                          <td><strong>Email</strong></td>
                        </tr>
                        <tr>
                          <td><?php
                              $sel_pemakai = mysqli_fetch_array(mysqli_query($koneksi, "select * from pemakai where id=" . $dataa['pemakai_id'] . "")); ?>
                            <?php echo $sel_pemakai['nama_pemakai']; ?></td>
                          <td>
                            <?php echo $sel_pemakai['kontak1_pemakai']; ?></td>
                          <td><?php echo $sel_pemakai['kontak2_pemakai']; ?></td>
                          <td>
                            <?php echo $sel_pemakai['email_pemakai']; ?></td>
                        </tr>

                      </table>
                    </div>

                    <br />


                    <br />

                    <div class="table-responsive">
                      <table width="100%" id="example1" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th valign="bottom">No</th>
                            <th valign="bottom"><strong>Nama Alkes</strong></th>

                            <th align="center" valign="bottom"><strong>Harga
                                Jual</strong></th>
                            <th align="center" valign="bottom"><strong>Tipe
                              </strong></th>
                            <th align="center" valign="bottom"><strong>Merk
                              </strong></th>
                            <th align="center" valign="bottom"><strong>Qty</strong></th>
                            <th valign="bottom"><strong>Total</strong></th>

                          </tr>
                        </thead>


                        <?php

                        $no = 0;
                        $q_akse = mysqli_query($koneksi, "select *,barang_dijual_qty.id as idd from barang_dijual_qty,barang_gudang where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $dataa['idd'] . "");
                        $jm = mysqli_num_rows($q_akse);
                        if ($jm != 0) {
                          while ($data_akse = mysqli_fetch_array($q_akse)) {
                            $no++;
                        ?>
                            <tr>
                              <td><?php echo $no; ?></td>
                              <td align="left"><?php echo $data_akse['nama_brg']; ?>
                              </td>

                              <td align="left"><?php echo "Rp" . number_format($data_akse['harga_jual_saat_itu'], 2, ',', '.'); ?></td>
                              <td align="left"><?php echo $data_akse['tipe_brg']; ?></td>
                              <td align="left"><?php echo $data_akse['merk_brg']; ?></td>
                              <td align="center"><?php echo $data_akse['qty_jual']; ?></td>
                              <td align="right"><?php echo "Rp" . number_format($data_akse['harga_jual_saat_itu'] * $data_akse['qty_jual'], 2, ',', '.'); ?></td>

                            </tr>

                        <?php }
                        } ?>
                        <tr bgcolor="#FF9900">
                          <td colspan="7"></td>
                        </tr>
                        <tr>
                          <td colspan="6" align="right"><strong> Total</strong></td>
                          <td align="right"><?php
                                            $total1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_satuan) as total1 from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $dataa['idd'] . ""));
                                            echo number_format($total1['total1'], 2, ',', '.');
                                            ?></td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right">Ongkir</td>
                          <td align="right"><?php echo number_format($dataa['ongkir'], 2, ',', '.'); ?></td>

                        </tr>
                        <!--
    <tr>
      <td colspan="6" align="right"><strong>DPP</strong></td>
      <td align="right"><?php echo number_format($dataa['dpp'], 2, ',', '.'); ?></td>
      <td align="center"></td>
    </tr>
    -->
                        <tr>
                          <td colspan="6" align="right">DPP ((Total + Ongkir) /1.1)</td>
                          <td align="right">
                            <?php

                            $dpp = ($dataa['ongkir'] + $total1['total1']) / 1.1;
                            echo number_format($dpp, 2, ',', '.');

                            ?>
                          </td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right">Diskon (<?php echo $dataa['diskon_jual'] . "%"; ?>)</td>
                          <td align="right"><?php
                                            $diskon = $dataa['diskon_jual'];
                                            echo $diskon . "%";
                                            ?></td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right">PPN (<?php echo $dataa['ppn_jual'] . "%"; ?>)
                          </td>
                          <td align="right">
                            <?php
                            $ppn = ($dpp) * $dataa['ppn_jual'] / 100;
                            echo number_format($ppn, 2, ',', '.');
                            ?>
                          </td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right">PPh (<?php echo $dataa['pph'] . "%"; ?>) </td>
                          <td align="right"><?php
                                            $pph = ($dpp) * $dataa['pph'] / 100;
                                            echo number_format($pph, 2, ',', '.');
                                            ?></td>

                        </tr>

                        <tr>
                          <td colspan="6" align="right">Zakat (<?php echo $dataa['zakat'] . "%"; ?>)</td>
                          <td align="right"><?php $zakat = $dpp * $dataa['zakat'] / 100;
                                            echo number_format($dpp * $dataa['zakat'] / 100, 2, ',', '.'); ?></td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right">Biaya Bank </td>
                          <td align="right"><?php echo number_format($dataa['biaya_bank'], 2, ',', '.'); ?></td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right" valign="bottom">
                            <h4><strong>Neto (DPP(Dengan Ongkir)-(PPN dari DPP(Dengan Ongkir)+PPh dari DPP(Dengan Ongkir)+Zakat dari DPP(Dengan Ongkir)+Biaya Bank)</strong>)</h4>
                          </td>
                          <td align="right" valign="bottom">
                            <h4><strong>
                                <?php
                                $total2 = $dpp - ($ppn + $pph + $zakat + $dataa['biaya_bank']);
                                echo number_format($total2, 2, ',', '.'); ?>
                              </strong></h4>
                          </td>

                        </tr>
                        <tr>
                          <td colspan="6" align="right" valign="bottom"><strong>Fee Supplier (DPP(Tanpa Ongkir)-(PPh dari DPP(Tanpa Ongkir)+Zakat dari DPP(Dengan Ongkir)+Biaya Bank)</strong>)<strong>*Diskon</strong></td>
                          <td align="right" valign="bottom">
                            <?php
                            $dpp_m = ($total1['total1'] / 1.1);
                            //$ppn_m = $dpp_m*$data['ppn_jual']/100;
                            $pph_m = $dpp_m * $dataa['pph'] / 100;
                            $zakat_m = $dpp_m * $dataa['zakat'] / 100;
                            $biaya_bank_m = $dataa['biaya_bank'];
                            $fee_marketing = ($dpp_m - ($pph_m + $zakat_m + $biaya_bank_m)) * ($diskon / 100);
                            echo "Rp" . number_format($fee_marketing, 2, ',', '.'); ?>
                          </td>

                        </tr>
                      </table>
                    </div>

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
    $.get("data/modal-ubah-piutang.php", {
        id: id,
        id_ubah: id_ubah
      },
      function(data) {
        $('#modal-ubah').html(data);
      }
    );
  }

  function getHeader() {
    $.get("data/header-piutang.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#header-piutang').html(data);
      }
    );
  }

  function getRiwayat() {
    loading();
    $.get("data/riwayat-pembayaran-piutang.php", {
        id: '<?php echo $_GET['id']; ?>'
      },
      function(data) {
        $('#riwayat-pembayaran').html(data);
      }
    );
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
        $.post("data/hapus-pembayaran-piutang.php", {
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

  function ubahPembayaran() {
    var dataform = $('#formUbah')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/ubah-pembayaran-piutang.php",
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

  function tambahPembayaran() {
    var dataform = $('#formData')[0];
    var data = new FormData(dataform);
    $.ajax({
      type: "post",
      url: "data/simpan-pembayaran-piutang.php",
      data: data,
      enctype: "multipart/form-data",
      contentType: false,
      processData: false,
      success: function(response) {
        if (response == 'S') {
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

  $(document).ready(function() {
    getHeader();
    getRiwayat();
  });
</script>