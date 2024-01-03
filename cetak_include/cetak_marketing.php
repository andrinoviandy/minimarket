<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekapan Penjualan _ Marketing ".$_POST['marketing']." ($_POST[tahun]).xls");
?>
<?php include "config/koneksi"; ?>
<?php session_start(); ?>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
        <style>
         .mytable{
                border:1px solid black; 
                border-collapse: collapse;
                width: 100%;
            }
            .mytable tr th, .mytable tr td{
                border:1px solid black; 
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
			  echo "<h3>Marketing : ".$_POST['marketing']." (".$_POST['tahun'].")"."</h3>"; 
			  ?>
                <table border="1" class="mytable">
  <thead>
    <tr>
      <td align="center" valign="top">&nbsp;<strong>No</strong>
        </th>
        
        <th align="center"><strong>Tanggal Dijual</strong></th>
        <th align="center">No PO</th>
     
      <th align="center"><strong>Dinas/RS/Puskemas/Klinik<br />(Tempat Tujuan)</strong></th>
      <th align="center">Provinsi</th>
      <th align="center">Kabupaten/Kota</th>
      <th align="center">Kecamatan</th>
      <th align="center">Kelurahan</th>
      <th align="center">Marketing</th>
      <th align="center">SubDis</th>
      <th align="center">Alkes</th>
      <th align="center"><strong>Qty</strong></th>
      <th align="center">Harga Satuan</th>
      <th align="center">Harga Total</th>
      </tr>
  </thead>
  <?php
	if ($_POST['marketing']=='all') {
		$query = mysqli_query($koneksi, "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty, barang_gudang,pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='$_POST[tahun]' order by barang_dijual.tgl_jual DESC");
		}
	else {
	 $query = mysqli_query($koneksi, "select *,barang_dijual.id as idd from barang_dijual,barang_dijual_qty, barang_gudang,pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and barang_dijual.marketing='".$_POST['marketing']."' and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='$_POST[tahun]' order by barang_dijual.tgl_jual DESC"); } 
  $no=0;
  while ($data = mysqli_fetch_assoc($query)) { 
  $no++;
  ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td>
    <?php echo date("d F Y",strtotime($data['tgl_jual']));	
	?>
    </td>
    <td><?php echo $data['no_po_jual']; ?></td>
    
    <td><?php echo $data['nama_pembeli']; ?></td>
    <td><?php echo $data['nama_provinsi']; ?></td>
    <td><?php echo $data['nama_kabupaten']; ?></td>
    <td><?php echo $data['nama_kecamatan']; ?></td>
    <td><?php echo $data['kelurahan_id']; ?></td>
    <td align="center"><?php echo $data['marketing']; ?></td>
    <td align="center"><?php echo $data['subdis']; ?></td>
    <td align="center"><?php echo $data['nama_brg']; ?></td>
    <td align="center"><?php echo $data['qty_jual']; ?></td>
    <td align="right"><?php echo $data['harga_jual_saat_itu']; ?></td>
    <td align="right"><?php echo $data['harga_jual_saat_itu']*$data['qty_jual']; ?></td>
    </tr>
  <?php } ?>
  <!--
  <tr>
    <td colspan="13" align="right"><h3><strong>Total : </strong></h3></td>
    <td align="right"><?php
	if ($_POST['marketing']=='all') {
		$query2 = mysqli_query($koneksi, "select sum(total_harga) as totall from barang_dijual,barang_dijual_qty, barang_gudang,pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='".$_POST['tahun']."'");
		$data2=mysqli_fetch_array($query2); 
		}
		else {
	$query2 = mysqli_query($koneksi, "select sum(total_harga) as totall from barang_dijual,barang_dijual_qty, barang_gudang,pembeli, alamat_provinsi, alamat_kabupaten, alamat_kecamatan where barang_gudang.id=barang_dijual_qty.barang_gudang_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and barang_dijual.marketing='".$_POST['marketing']."' and DATE_FORMAT(barang_dijual.tgl_jual,'%Y')='".$_POST['tahun']."'");
	$data2=mysqli_fetch_array($query2); 
	}
	echo $data2['totall'];
	?>
    </td>
  </tr>
  -->
</table>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List --><!-- /.box -->

        <!-- quick email widget --></section>
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