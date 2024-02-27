<?php

$id = $_GET['id'];
require("config/koneksi.php");
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_dikirim.id as idd,barang_gudang.id as id_gudang from barang_dikirim,barang_dikirim_detail,barang_teknisi,barang_teknisi_detail, barang_dijual, pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan,barang_gudang_detail,barang_gudang,pemakai where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dijual.id=barang_dikirim.barang_dijual_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and pembeli.id=barang_dijual.pembeli_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pemakai.id=barang_dijual.pemakai_id and barang_teknisi.id=$id and barang_dikirim.id=$_GET[id_kirim]"));
?>
<html>

<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
  <title>Cetak Surat Perintah Instalasi</title>
  <style>
    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    #container {
      min-height: 100%;
      position: relative;
    }

    #header {
      background: #ff0;
      padding: 10px;
    }

    #body {
      padding: 10px;
      padding-bottom: 60px;
      /* sesuaikan dengan tinggi footer */
    }

    #footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 60px;
      font-size: 13px;
      /* tinggi dari footer */

    }

    .mytable {
      border: 1px solid black;
      border-collapse: collapse;
      width: 100%;
    }

    .mytable tr th {
      border: 1px solid black;
      padding: 5px 10px;
    }

    .mytable tr td {
      border-right: 1px solid black;
      padding: 5px 10px;
    }

    .mytable tr td.noborder {
      border: 0px solid black;
      padding: 5px 10px;
    }

    .mytable tr.bordered {
      border-bottom: 1px solid black;
    }

    .mytable2 {
      border: 1px thin black;
      border-collapse: collapse;
      width: 100%;
      height: 100%;
    }

    .mytable3 {
      border: 0px;
      border-collapse: collapse;
      font-size: 12px;
    }

    .mytable2 tr th,
    .mytable2 tr td {
      border: 1px thin black;
      padding: 5px 10px;
    }

    .mytable3 tr th,
    .mytable3 tr td {
      border: 0px;
      padding: 3px;
      vertical-align: top;
      text-align: justify;
    }
  </style>
  <link href='logo.png' rel='icon'>
</head>

<body onLoad="window.print();">
  <div id="container">
    <div style="position:absolute; top:0px; bottom: 50px">
      <font style="float: right">Pry : <?php echo $data['marketing']; ?></font>
      <br>
      <center>
        <font size="+2" style="font-family:Arial, Helvetica, sans-serif"><b>SURAT PERINTAH INSTALASI</b></font>
        </font>
      </center><br>
      <table width="100%">
        <tr>
          <td colspan="4" rowspan="3" valign="top" style="font-family:Tahoma, Geneva, sans-serif"><strong>PT. CIPTA VARIA KHARISMA UTAMA<br>
              Jl. Utan Kayu Raya No.105A<br>
              Utan Kayu Utara, Matraman<br>
              Jakarta Timur</strong></td>
          <td width="2%" rowspan="3">&nbsp;</td>
          <td width="17%" height="21">
            <font>Nomor</font>
          </td>
          <td width="25%" align="right"><?php echo $data['no_spk']; ?></td>
        </tr>
        <tr>
          <td height="21">
            <font>Tanggal</font>
          </td>
          <td width="25%" align="right"><?php echo date("d M Y", strtotime($data['tgl_spk'])); ?></td>
        </tr>
        <tr>
          <td height="21">
            <font>No. PO/ID</font>
          </td>
          <td width="25%" align="right"><?php echo $data['no_po_jual']; ?></td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="5%" valign="top">Paket</td>
          <td width="2%" valign="top">:</td>
          <td width="31%" align="left" valign="top"><?php echo $data['nama_paket']; ?></td>
          <td width="5%" valign="top">&nbsp;</td>
          <td colspan="3" valign="top" style="font-size:14px"><strong>Kepada Yth,</strong><br />
            <b><?php echo $data['nama_pembeli']; ?></b><br>
            <?php echo $data['jalan'] . " Kel." . $data['kelurahan_id']; ?><br>
            <?php echo "Kec." . ucwords(strtolower($data['nama_kecamatan'])) . ", Kab." . ucwords(strtolower($data['nama_kabupaten'])) . ", " . ucwords(strtolower($data['nama_provinsi'])); ?><br>
            UP : <?php echo $data['nama_pemakai']; ?><br>
            Telp : <?php echo $data['kontak1_pemakai'] . " / " . $data['kontak2_pemakai']; ?>
            <?php if ($data['alamat2'] != '') { ?>
              <hr>
              <?php echo $data['alamat2']; ?>
            <?php } ?>
          </td>
        </tr>
      </table>
      <br>
      Barang - barang yang di instalasi, sebagai berikut :<br><br>
      <table width="100%" class="mytable" style="font-size:13px">
        <tr>
          <th align="center"><strong>No</strong></th>
          <th align="center"><strong>Item</strong></th>
          <th align="center" colspan="2"><strong>Item Description</strong></th>
          <th align="center" width="12%"><strong>Qty</strong></th>
          <th align="center" width="25%"><strong>Serial Number</strong></th>
        </tr>
        <?php
        $no = 0;
        // $q = mysqli_query($koneksi, "select *,barang_dikirim.id as idd, barang_gudang.id as id_gudang from barang_dikirim,barang_dikirim_detail, barang_gudang_detail,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and status_batal=0 and barang_dikirim.id=" . $id . "");
        $q = mysqli_query($koneksi, "select distinct barang_dikirim_detail.barang_dijual_qty_id, barang_dikirim_detail.jml_kirim, tipe_brg, nama_brg, satuan, barang_gudang.kategori_brg from barang_dikirim_detail left join barang_dijual_qty on barang_dijual_qty.id = barang_dikirim_detail.barang_dijual_qty_id left join barang_gudang on barang_gudang.id=barang_dijual_qty.barang_gudang_id where barang_dikirim_detail.barang_dikirim_id=" . $_GET['id_kirim'] . "");
        while ($d = mysqli_fetch_array($q)) {
          $no++;
          $rincian_set = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select count(*) from barang_dikirim_detail where barang_dijual_qty_id = $d[barang_dijual_qty_id]) as jmm from barang_dijual_qty_detail left join barang_gudang on barang_gudang.id = barang_dijual_qty_detail.barang_gudang_id where barang_dijual_qty_id = $d[barang_dijual_qty_id]"));
          $rincian_sat = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml, (select count(*) from barang_dikirim_detail where barang_dijual_qty_id = $d[barang_dijual_qty_id] and kategori_brg != 'Satuan') as jmm from barang_dijual_qty_detail left join barang_gudang on barang_gudang.id = barang_dijual_qty_detail.barang_gudang_id where barang_dijual_qty_id = $d[barang_dijual_qty_id]"));
        ?>
          <tr>
            <td align="center" valign="top"><?php echo $no; ?></td>
            <td align="center" valign="top">
              <?php echo $d['tipe_brg']; ?>
            </td>
            <td valign="top" colspan="2">
              <?php
              echo $d['nama_brg'];
              ?>
            </td>
            <td align="center" valign="top">
              <?php
              $jm = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from barang_dikirim_detail,barang_gudang_detail where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]"));
              // $j_batal = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail,barang_gudang_detail,barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.barang_dikirim_id=$data2[id_kirim] and status_batal=1 and barang_gudang.id=$d[id_gudang]"));
              echo $d['jml_kirim'] . " " . $d['satuan'] . "<br>";
              // echo $jm['jml'] . " " . $d['satuan'] . "<br>";
              // if ($j_batal !== 0) {
              // echo "Batal : " . $j_batal;
              // } 
              ?>
            </td>
            <td align="center" valign="top">
              <table class="mytable3">
                <?php
                if ($d['kategori_brg'] == 'Satuan') {
                  $qq = mysqli_query($koneksi, "select barang_gudang.nama_brg, barang_gudang_detail.no_seri_brg from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Satuan' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]");
                  while ($dd = mysqli_fetch_array($qq)) {
                    echo "<tr><td>-</td><td>" . $dd['no_seri_brg'] . "</td></tr>";
                  }
                }
                if ($d['kategori_brg'] == 'Aksesoris') {
                  $qq = mysqli_query($koneksi, "select barang_gudang.nama_brg, barang_gudang_detail.no_seri_brg from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Aksesoris' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]");
                  while ($dd = mysqli_fetch_array($qq)) {
                    echo "<tr><td>-</td><td>" . $dd['no_seri_brg'] . "</td></tr>";
                  }
                }
                ?>
              </table>
            </td>
          </tr>
          <?php
          if ($d['kategori_brg'] == 'Set') {
            if ($rincian_set['jml'] > 0) {
          ?>
              <tr>
                <td></td>
                <td></td>
                <td colspan="2">Kelengkapan :</td>
                <td></td>
                <td></td>
              </tr>
              <?php
              // $q3 = mysqli_query($koneksi, "select barang_gudang.nama_brg, barang_gudang_detail.no_seri_brg from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Satuan' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]");
              $q3 = mysqli_query($koneksi, "select distinct barang_gudang.nama_brg, barang_dikirim_detail.barang_gudang_satuan_id as id_detail, satuan from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Satuan' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]");
              while ($d3 = mysqli_fetch_array($q3)) {
              ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td class="noborder" width="5px" valign="top">-</td>
                  <td valign="top"><?php echo $d3['nama_brg'] ?></td>
                  <td align="center">
                    <?php
                    $q4 = mysqli_query($koneksi, "select barang_gudang_detail.no_seri_brg from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Aksesoris' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id] and barang_dikirim_detail.barang_gudang_akse_id = $d3[id_detail]");
                    echo mysqli_num_rows($q4) . " " . $d3['satuan'];
                    ?>
                  </td>
                  <td align="center" valign="top">
                    <table class="mytable3">
                      <?php
                      while ($d4 = mysqli_fetch_array($q4)) {
                        echo "<tr><td>-</td><td>" . $d4['no_seri_brg'] . "</td></tr>";
                      }
                      ?>
                    </table>
                  </td>
                </tr>
              <?php
              }
            }
          }
          if ($d['kategori_brg'] == 'Satuan') {
            if ($rincian_sat['jml'] > 0) {
              ?>
              <tr>
                <td></td>
                <td></td>
                <td colspan="2">Kelengkapan :</td>
                <td></td>
                <td></td>
              </tr>
              <?php
              // $q3 = mysqli_query($koneksi, "select barang_gudang.nama_brg, barang_gudang_detail.no_seri_brg from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Aksesoris' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]");
              $q3 = mysqli_query($koneksi, "select distinct barang_gudang.nama_brg, barang_dikirim_detail.barang_gudang_akse_id as id_detail, satuan from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Aksesoris' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id]");
              while ($d3 = mysqli_fetch_array($q3)) {
              ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td class="noborder" width="5px" valign="top">-</td>
                  <td valign="top"><?php echo $d3['nama_brg'] ?></td>
                  <td align="center">
                    <?php
                    $q4 = mysqli_query($koneksi, "select barang_gudang_detail.no_seri_brg from barang_dikirim_detail,barang_gudang_detail, barang_gudang where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dikirim_detail.kategori_brg = 'Aksesoris' and barang_dikirim_detail.barang_dijual_qty_id=$d[barang_dijual_qty_id] and barang_dikirim_detail.barang_gudang_akse_id = $d3[id_detail]");
                    echo mysqli_num_rows($q4) . " " . $d3['satuan'];
                    ?>
                  </td>
                  <td valign="top" align="center">
                    <table class="mytable3">
                      <?php
                      while ($d4 = mysqli_fetch_array($q4)) {
                        echo "<tr><td>-</td><td>".$d4['no_seri_brg'] . "</td></tr>";
                      }
                      ?>
                    </table>
                  </td>
                </tr>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <tr class="bordered">
            <td></td>
            <td></td>
            <td class="noborder" width="5px"></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        <?php } ?>
      </table>
      <br>
      <table width="100%">
        <tr>
          <td colspan="5" valign="top" style="margin-bottom:150px;">
            <table width="100%">
              <tr>
                <td width="22%" valign="top" style="padding-bottom:30px;">Lokasi Instalasi</td>
                <td valign="top" width="2%">:</td>
                <td colspan="4" valign="top" style="font-size:12px"><b><?php echo $data['nama_pembeli']; ?></b><br><?php echo $data['jalan'] . " Kel." . $data['kelurahan_id']; ?><br>
                  <?php echo "Kec." . ucwords(strtolower($data['nama_kecamatan'])) . ", Kab." . ucwords(strtolower($data['nama_kabupaten'])) . ", " . ucwords(strtolower($data['nama_provinsi'])); ?></td>
              </tr>
              <tr>
                <td width="22%" valign="top" style="font-size:12px">Koordinasi Instalasi</td>
                <td valign="top">:</td>
                <td colspan="4" valign="top" style="font-size:12px"><?php echo $data['subdis']; ?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <hr>Yan Herman
          </td>
          <td width="17%">&nbsp;</td>
          <td width="25%" align="center">
            <hr>
            Tri Tinitah Kusumastuti
          </td>
          <td width="16%" align="center">&nbsp;</td>
          <!-- <td width="24%" align="center"><hr>Slamet Imam Santoso</td> -->
          <td width="24%" align="center">
            <hr>Irdiyanto
          </td>
        </tr>
      </table>
      <br><br><br><br><br><br><br><br>
    </div>
    <div style="position:absolute; bottom:10px">
      1. Putih : Teknisi, 2. Merah : Teknisi, 3. Keuangan, 4. Hijau : Administrasi, 5. Biru : Copy Admin
    </div>
  </div>
  <script type="text/javascript">
    function PrintPage() {
      window.print();
    }
    window.addEventListener('DOMContentLoaded', (event) => {
      PrintPage()
      setTimeout(function() {
        window.close()
      }, 750)
    });
  </script>
</body>

</html>