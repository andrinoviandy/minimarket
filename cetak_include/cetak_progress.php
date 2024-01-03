<?php

include "config/koneksi";
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,tb_maintenance_detail.id as idd from kategori_job,tb_laporan_kerusakan,tb_laporan_kerusakan_detail,alat_pelatihan,alat_uji_detail,barang_teknisi_detail,barang_dikirim_detail,barang_dijual_detail,barang_dijual,barang_gudang_detail,barang_gudang,tb_teknisi,tb_maintenance,tb_maintenance_detail,akun_customer,pembeli where barang_dijual.id=barang_dijual_detail.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and akun_customer.id=tb_laporan_kerusakan.akun_customer_id and kategori_job.id=tb_laporan_kerusakan_detail.kategori_job_id and tb_laporan_kerusakan.id=tb_laporan_kerusakan_detail.tb_laporan_kerusakan_id and alat_pelatihan.id=tb_laporan_kerusakan_detail.alat_pelatihan_id and alat_uji_detail.id=alat_pelatihan.alat_uji_detail_id and barang_teknisi_detail.id=alat_uji_detail.barang_teknisi_detail_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dijual_detail.id=barang_dikirim_detail.barang_dijual_detail_id and barang_gudang_detail.id=barang_dijual_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and tb_maintenance.id=tb_maintenance_detail.tb_maintenance_id and tb_teknisi.id=tb_maintenance.teknisi_id and tb_laporan_kerusakan_detail.id=tb_maintenance_detail.tb_laporan_kerusakan_detail_id and tb_maintenance_detail.id=".$_GET['id_alkes'].""));
?>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
        <title>Cetak Progress Perbaikan Alkes</title>
        <style>
         .mytable{
                border:1px solid black; 
                border-collapse: collapse;
                width: 100%;
				border-color:#000099;
            }
			.mytable2{
                border:1px solid black; 
                border-collapse: collapse;
                border-color:#000099;
            }
            
        </style>
        <link href='logo.png' rel='icon'>
    </head>
    <body onLoad="window.print();" style="color:#000099">
    <table width="100%">
  <tr>
    <td width="47%" rowspan="2" valign="top"><img src="img/kop.png" width="340px" height="auto" /></td>
    <td width="3%">&nbsp;</td>
    <td width="50%" align="center"><font color="#000099" style="font-size:20px"><b>DETAIL PROGRESS<br>REPORT</b></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><table width="300px" class="mytable2">
      <tr>
        <td height="30px"><strong>&nbsp;&nbsp;No :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/CR/TECH/KU/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/20</strong></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<strong>Customer Data</strong><br />
<table class="mytable">
  <tr valign="top">
    <td width="50%" style="padding:10px"><table width="100%">
      <tr height="30px">
        <td width="41%" valign="top">Customer</td>
        <td width="4%" valign="top">:</td>
        <td width="55%" valign="top"><?php echo $data['nama_user']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Address</td>
        <td valign="top">:</td>
        <td rowspan="2" valign="top"><?php echo $data['alamat_user']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        </tr>
      <tr height="30px">
        <td valign="top">City / State</td>
        <td valign="top">:</td>
        <td valign="top">-</td>
      </tr>
      <tr height="30px">
        <td valign="top">Province</td>
        <td valign="top">:</td>
        <td valign="top">-</td>
      </tr>
    </table></td>
    <td width="50%" style="padding:10px"><table width="100%">
      <tr height="30px">
        <td width="39%" valign="top">Contact Person</td>
        <td width="5%" valign="top">:</td>
        <td width="56%" valign="top"><?php echo $data['telp_user']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Phone</td>
        <td valign="top">:</td>
        <td valign="top">-</td>
      </tr>
      <tr height="30px">
        <td valign="top">HP</td>
        <td valign="top">:</td>
        <td valign="top">-</td>
      </tr>
      <tr height="30px">
        <td valign="top">Email</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $data['email_user']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Department</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $data['nama_pembeli']; ?></td>
      </tr>
    </table></td>
  </tr>
  </table><br />
<strong>Equipment Data</strong>
<br />
<table class="mytable">
  <tr valign="top">
    <td width="50%" style="padding:10px"><table width="100%">
      <tr height="30px">
        <td width="41%" valign="top">Equipment Name</td>
        <td width="5%" valign="top">:</td>
        <td width="54%" valign="top"><?php echo $data['nama_brg']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Model / Type</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $data['tipe_brg']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Installation Date</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo date("d F Y",strtotime($data['tgl_i'])); ?></td>
      </tr>
    </table></td>
    <td width="50%" style="padding:10px"><table width="100%">
      <tr height="30px">
        <td width="39%" valign="top">Brand</td>
        <td width="5%" valign="top">:</td>
        <td width="56%" valign="top"><?php echo $data['merk_brg']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Serial Number</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $data['no_seri_brg']; ?></td>
      </tr>
      <tr height="30px">
        <td valign="top">Install By</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $data['nama_teknisi']; ?></td>
      </tr>
    </table></td>
  </tr>
  </table>
<br />

<strong>Detail Progress</strong>
<br />
<table border="1" class="mytable">
  <tr>
    <td width="20%" align="center" style="padding:10px"><strong>Tanggal</strong></td>
    <td width="30%" align="center"><strong>Desk. Kerusakan</strong></td>
    <td width="30%" align="center"><strong>Desk. Perbaikan</strong></td>
    <td width="20%" align="center"><strong>Lampiran</strong></td>
  </tr>
 <?php
 $q = mysqli_query($koneksi, "select * from progress_maintenance where tb_maintenance_detail_id=$_GET[id_alkes]"); 
 while ($d = mysqli_fetch_array($q)) {
 ?>
  <tr>
    <td style="padding:5px"><?php echo date("d-m-Y",strtotime($d['tgl_progress'])); ?></td>
    <td style="padding:5px"><?php echo $d['deskripsi_kerusakan']; ?></td>
    <td style="padding:5px"><?php echo $d['deskripsi_perbaikan']; ?></td>
    <td align="center" style="padding:5px"><img src="gambar_progress/<?php echo $d['lampiran']; ?>" width="50px" /></td>
  </tr>
<?php } ?>
</table>
<br />
<table border="1" class="mytable">
  <tr>
    <td width="30%"><strong>&nbsp;&nbsp;Date :</strong></td>
    <td width="35%"><strong>&nbsp;&nbsp;Receipt By :</strong></td>
    <td width="35%"><strong>&nbsp;&nbsp;Handle By Engineer :</strong></td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td height="90">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    </body>
</html>
