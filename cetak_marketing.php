<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekapan Penjualan _ Marketing " . $_POST['marketing'] . " ($_POST[tahun]).xls");
?>
<?php require("config/koneksi.php"); ?>
<?php session_start(); ?>
<html>

<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
  <style>
    .mytable {
      border: 1px solid black;
      border-collapse: collapse;
      width: 100%;
    }

    .mytable tr th,
    .mytable tr td {
      border: 1px solid black;
      padding: 2px 5px;
    }
  </style>
</head>

<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 align="center">
        Penjualan Alkes</h1>
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
              <div class="input-group col-lg-12">
                <br />
                <?php
                echo "<h3>Marketing : " . $_POST['marketing'] . " (" . $_POST['tahun'] . ")" . "</h3>";
                ?>
                <table border="1" class="mytable">
                  <thead>
                    <tr>
                      <td colspan="20" align="right">Total Keseluruhan : </td>
                      <td align="right">
                        <?php
                        if ($_POST['marketing'] == 'all') {
                          $query2 = mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as totall from barang_dijual,barang_dijual_qty where barang_dijual.id=barang_dijual_qty.barang_dijual_id and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='" . $_POST['tahun'] . "'");
                          $data2 = mysqli_fetch_array($query2);
                        } else {
                          $query2 = mysqli_query($koneksi, "select sum(total_harga) as totall from barang_dijual,barang_dijual_qty, barang_gudang,pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and barang_dijual.marketing='" . $_POST['marketing'] . "' and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='" . $_POST['tahun'] . "'");
                          $data2 = mysqli_fetch_array($query2);
                        }
                        echo number_format($data2['totall'], 2, ',', '.');
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="21" style="height: 5px; background-color:cadetblue"></td>
                    </tr>
                    <tr>
                      <th align="center" valign="top">&nbsp;<strong>No</strong></th>
                      <th align="center"><strong>Tanggal Dijual</strong></th>
                      <th align="center">No PO</th>
                      <th align="center"><strong>Dinas/RS/Puskemas/Klinik/Dll</strong></th>
                      <th align="center">Provinsi</th>
                      <th align="center">Kabupaten/Kota</th>
                      <th align="center">Kecamatan</th>
                      <th align="center">Kelurahan</th>
                      <th align="center">Jalan</th>
                      <th align="center">Telp. Dinas/RS/Dll</th>
                      <th align="center">Pemakai</th>
                      <th align="center">Email Pemakai</th>
                      <th align="center">Marketing/PIC</th>
                      <th align="center">SubDis</th>
                      <th align="center">Nama Barang</th>
                      <th align="center">Tipe Barang</th>
                      <th align="center">Merk Barang</th>
                      <th align="center"><strong>Qty | No Seri</strong></th>
                      <th align="center">Harga Satuan</th>
                      <th align="center">Sub Total</th>
                      <th align="center">Total Harga</th>
                    </tr>
                  </thead>
                  <?php
                  if ($_POST['marketing'] == 'all') {
                    $query = mysqli_query($koneksi, "select *,barang_dijual.id as idd from barang_dijual, pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan, pemakai where pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pemakai.id = barang_dijual.pemakai_id and year(barang_dijual.tgl_jual)='" . $_POST['tahun'] . "' order by barang_dijual.tgl_jual DESC, barang_dijual.id DESC");
                  } else {
                    $query = mysqli_query($koneksi, "select *,barang_dijual.id as idd from barang_dijual, pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan, pemakai where pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pemakai.id = barang_dijual.pemakai_id and barang_dijual.marketing='" . $_POST['marketing'] . "' and year(barang_dijual.tgl_jual)='$_POST[tahun]' order by barang_dijual.tgl_jual DESC");
                  }
                  $no = 0;
                  while ($data = mysqli_fetch_array($query)) {
                    $no++;
                  ?>
                    <tr>
                      <td align="center" valign="top"><?php echo $no; ?></td>
                      <td align="center" valign="top">
                        <?php echo date("d F Y", strtotime($data['tgl_jual']));
                        ?>
                      </td>
                      <td align="center" valign="top"><?php echo $data['no_po_jual']; ?></td>
                      <td valign="top"><?php echo $data['nama_pembeli']; ?></td>
                      <td valign="top"><?php echo $data['nama_provinsi']; ?></td>
                      <td valign="top"><?php echo $data['nama_kabupaten']; ?></td>
                      <td valign="top"><?php echo $data['nama_kecamatan']; ?></td>
                      <td valign="top"><?php echo $data['kelurahan_id']; ?></td>
                      <td valign="top"><?php echo $data['jalan']; ?></td>
                      <td valign="top"><?php echo $data['kontak_rs']; ?></td>
                      <td valign="top"><?php echo $data['nama_pemakai']; ?></td>
                      <td valign="top"><?php echo $data['email_pemakai']; ?></td>
                      <td valign="top" align="center"><?php echo $data['marketing']; ?></td>
                      <td valign="top" align="center"><?php echo $data['subdis']; ?></td>
                      <td valign="top">
                        <table width="100%" border="1">
                          <?php
                          $brg = mysqli_query($koneksi, "select nama_brg from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $data['idd'] . " order by nama_brg ASC");
                          while ($d_brg = mysqli_fetch_array($brg)) {
                          ?>
                            <tr>
                              <td valign="top"><?php echo $d_brg['nama_brg'] ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td valign="top">
                        <table width="100%" border="1">
                          <?php
                          $brg2 = mysqli_query($koneksi, "select tipe_brg from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $data['idd'] . " order by nama_brg ASC");
                          while ($d_tipe = mysqli_fetch_array($brg2)) {
                          ?>
                            <tr>
                              <td valign="top"><?php echo $d_tipe['tipe_brg'] ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td valign="top">
                        <table width="100%" border="1">
                          <?php
                          $brg3 = mysqli_query($koneksi, "select merk_brg from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $data['idd'] . " order by nama_brg ASC");
                          while ($d_merk = mysqli_fetch_array($brg3)) {
                          ?>
                            <tr>
                              <td valign="top"><?php echo $d_merk['merk_brg'] ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td align="center" valign="top">
                        <table width="100%" border="1">
                          <?php
                          $qty = mysqli_query($koneksi, "select barang_dijual_qty.id as idd, qty_jual from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $data['idd'] . " order by nama_brg ASC");
                          while ($d_brg = mysqli_fetch_array($qty)) {
                          ?>
                            <tr>
                              <td valign="top" align="center"><?php echo $d_brg['qty_jual'] ?></td>
                              <td>
                                <table width="100%" border="1">
                                  <?php
                                  $no_seri = mysqli_query($koneksi, "select no_seri_brg from barang_dikirim_detail, barang_gudang_detail where barang_gudang_detail.id = barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty_id=" . $d_brg['idd'] . " and kategori_brg != 'Aksesoris' order by no_seri_brg ASC");
                                  while ($dd = mysqli_fetch_array($no_seri)) {
                                  ?>
                                    <tr>
                                      <td valign="top"><?php echo $dd['no_seri_brg'] ?></td>
                                    </tr>
                                  <?php } ?>
                                </table>
                              </td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td align="right" valign="top">
                        <table width="100%" border="1">
                          <?php
                          $harga_jual = mysqli_query($koneksi, "select harga_jual_saat_itu from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $data['idd'] . " order by nama_brg ASC");
                          while ($d_brg = mysqli_fetch_array($harga_jual)) {
                          ?>
                            <tr>
                              <td valign="top"><?php echo $d_brg['harga_jual_saat_itu'] ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td align="right" valign="top">
                        <table width="100%" border="1">
                          <?php
                          $sub_total = mysqli_query($koneksi, "select (qty_jual*harga_jual_saat_itu) as sub_total from barang_gudang,barang_dijual_qty where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual_id=" . $data['idd'] . " order by nama_brg ASC");
                          while ($d_brg = mysqli_fetch_array($sub_total)) {
                          ?>
                            <tr>
                              <td valign="top"><?php echo $d_brg['sub_total'] ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </td>
                      <td align="right" valign="top">
                        <?php
                        $q_total = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as total from barang_dijual_qty where barang_dijual_id = " . $data['idd'] . ""));
                        echo $q_total['total'];
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="21" style="height: 5px; background-color:cadetblue"></td>
                  </tr>
                  <tr>
                    <td colspan="20" align="right">Total Keseluruhan : </td>
                    <td align="right">
                      <?php
                      if ($_POST['marketing'] == 'all') {
                        $query2 = mysqli_query($koneksi, "select sum(qty_jual*harga_jual_saat_itu) as totall from barang_dijual,barang_dijual_qty where barang_dijual.id=barang_dijual_qty.barang_dijual_id and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='" . $_POST['tahun'] . "'");
                        $data2 = mysqli_fetch_array($query2);
                      } else {
                        $query2 = mysqli_query($koneksi, "select sum(total_harga) as totall from barang_dijual,barang_dijual_qty, barang_gudang,pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and barang_dijual.marketing='" . $_POST['marketing'] . "' and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='" . $_POST['tahun'] . "'");
                        $data2 = mysqli_fetch_array($query2);
                      }
                      echo number_format($data2['totall'], 2, ',', '.');
                      ?>
                    </td>
                  </tr>
                  <!--
  <tr>
    <td colspan="13" align="right"><h3><strong>Total : </strong></h3></td>
    <td align="right">
    </td>
  </tr>
  -->
                </table>
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
</body>

</html>