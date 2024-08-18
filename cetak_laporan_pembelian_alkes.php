<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekapan Pembelian Alkes - " . date("d/m/Y", strtotime($_GET['tgl1'])) . " - " . date("d/m/Y", strtotime($_GET['tgl2'])) . ".xls");
error_reporting(0);
?>
<?php require("config/koneksi.php"); ?>
<h2 align="center" style="margin-bottom:0px"><strong>PT. CIPTA VARIA KHARISMA UTAMA</strong></h2>
<center>
    Rekapan Pembelian Alkes
    <br />
    Tanggal : <?php echo date("d/m/Y", strtotime($_GET['tgl1'])) . " - " . date("d/m/Y", strtotime($_GET['tgl2'])) ?>
    <br />
    <!-- Filter : -->
    <?php /*
    if ($_GET['filter'] == '1') {
        $dt = mysqli_fetch_array(mysqli_query($koneksi, "select nama_principle from principle where id = " . $_GET['principle_id'] . ""));
        echo $dt['nama_principle'];
    } else if ($_GET['filter'] == '2') {
        if ($_GET['provinsi']) {
            if ($_GET['provinsi'] == 'all') {
                echo "Semua Provinsi";
            } else {
                $dt1 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_provinsi from alamat_provinsi where id = $_GET[provinsi]"));
                echo "Provinsi " . ucwords(strtolower($dt1['nama_provinsi']));
                if ($_GET['kabupaten'] != 'all') {
                    $dt2 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_kabupaten from alamat_kabupaten where id = $_GET[kabupaten]"));
                    echo " Kabupaten " . ucwords(strtolower($dt2['nama_kabupaten']));
                    if ($_GET['kecamatan'] != 'all') {
                        $dt3 = mysqli_fetch_array(mysqli_query($koneksi, "select nama_kecamatan from alamat_kecamatan where id = $_GET[kecamatan]"));
                        echo " Kecamatan " . ucwords(strtolower($dt3['nama_kecamatan']));
                    }
                }
            }
        }
    } else {
        echo "-";
    } */
    ?>
</center>
<br />
<table width="100%" id="" border="1">
    <thead>
        <tr>
            <th align="center" rowspan="2">No</th>
            <th align="center" rowspan="2">Jenis PO</th>
            <th align="center" rowspan="2">Tanggal Pembelian</th>
            <th align="center" rowspan="2">No PO</th>
            <th align="center" colspan="5">Principle</th>
            <th align="center" colspan="6">Alkes</th>
            <th align="center" rowspan="2">Cara Bayar</th>
            <th align="center" rowspan="2">Jalur Pengiriman</th>
            <th align="center" rowspan="2">Mata Uang</th>
            <th align="center" rowspan="2">Harga Total</th>
            <th align="center" rowspan="2">PPN</th>
            <th align="center" rowspan="2">Total + PPN</th>
        </tr>
        <tr>
            <th>Nama Principle</th>
            <th>Alamat</th>
            <th>Telp</th>
            <th>Fax</th>
            <th>Attn</th>
            <th>Nama Alkes</th>
            <th>Tipe</th>
            <th>Qty</th>
            <th>Harga PerUnit</th>
            <th>Diskon</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php
    if (isset($_GET['jenis_po'])) {
        if ($_GET['jenis_po'] == 1) {
            $query = mysqli_query($koneksi, "select *,barang_pesan.id as idd from barang_pesan,mata_uang,principle where principle.id=barang_pesan.principle_id and mata_uang.id=barang_pesan.mata_uang_id and jenis_po = 'Dalam Negeri' and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_po_pesan DESC");
        } else {
            $query = mysqli_query($koneksi, "select *,barang_pesan.id as idd from barang_pesan,mata_uang,principle where principle.id=barang_pesan.principle_id and mata_uang.id=barang_pesan.mata_uang_id and jenis_po = 'Luar Negeri' and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_po_pesan DESC");

        }
    } else {
        $query = mysqli_query($koneksi, "select *,barang_pesan.id as idd from barang_pesan,mata_uang,principle where principle.id=barang_pesan.principle_id and mata_uang.id=barang_pesan.mata_uang_id and tgl_po_pesan between '$_GET[tgl1]' and '$_GET[tgl2]' order by tgl_po_pesan DESC");
    }
    // membuka file JSON
    // if ($_GET['filter'] == '1') {
    //     $file = file_get_contents("http://localhost/ALKES_2/json/rekapan_penjualan.php?filter=1&pembeli=" . $_GET['pembeli'] . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    // } else if ($_GET['filter'] == '2') {
    //     if ($_GET['provinsi'] == 'all') {
    //         $file = file_get_contents("http://localhost/ALKES_2/json/rekapan_penjualan.php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    //     } else {
    //         if ($_GET['kabupaten'] == 'all') {
    //             $file = file_get_contents("http://localhost/ALKES_2/json/rekapan_penjualan.php?filter=2&provinsi=" . $_GET['provinsi'] . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    //         } else {
    //             if ($_GET['kecamatan'] == 'all') {
    //                 $file = file_get_contents("http://localhost/ALKES_2/json/rekapan_penjualan.php?filter=2&provinsi=" . $_GET['provinsi'] . "&kabupaten=" . $_GET['kabupaten'] . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    //             } else {
    //                 $file = file_get_contents("http://localhost/ALKES_2/json/rekapan_penjualan.php?filter=2&provinsi=" . $_GET['provinsi'] . "&kabupaten=" . $_GET['kabupaten'] . "&kecamatan=" . $_GET['kecamatan'] . "&tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    //             }
    //         }
    //     }
    // } else {
    //     $file = file_get_contents("http://localhost/ALKES_2/json/rekapan_penjualan.php?tgl1=" . $_GET['tgl1'] . "&tgl2=" . $_GET['tgl2'] . "");
    // }
    // $json = json_decode($file, true);
    // $jml = count($json);
    // for ($i = 0; $i < $jml; $i++) {
    //echo "Nama Barang ke-".$i." : " . $json[$i]['nama_brg'] . "<br />";
    //echo 'Nama Anggota ke-3 : ' . $json['2']['nama_brg'];
    $no = 0;
    while ($data = mysqli_fetch_array($query)) {
        $no++;
    ?>
        <tr>
            <td align="center" valign="top"><?php echo $no; ?></td>
            <td valign="top"><?php echo $data['jenis_po']; ?></td>
            <td valign="top">
                <?php if ($data['tgl_po_pesan'] != '0000-00-00') {
                    echo date("d F Y", strtotime($data['tgl_po_pesan']));
                }
                ?>
            </td>
            <td valign="top"><?php echo $data['no_po_pesan']; ?></td>
            <td valign="top"><?php echo $data['nama_principle']; ?></td>
            <td valign="top"><?php echo $data['alamat_principle']; ?></td>
            <td valign="top"><?php echo $data['telp_principle']; ?></td>
            <td valign="top"><?php echo $data['fax_principle']; ?></td>
            <td valign="top"><?php echo $data['attn_principle']; ?></td>
            <td colspan="6" valign="top">
                <table border="1">
                    <?php
                    $q23 = mysqli_query($koneksi, "select * from barang_pesan_detail, barang_gudang where barang_gudang.id = barang_pesan_detail.barang_gudang_id and barang_pesan_id = " . $data['idd'] . "");

                    $n2 = 0;
                    while ($d1 = mysqli_fetch_array($q23)) {
                        $n2++;
                    ?>
                        <tr>
                            <td valign="top"><?php echo $d1['nama_brg'] ?></td>
                            <td valign="top"><?php echo $d1['tipe_brg'] ?></td>
                            <td valign="top" align="center"><?php echo $d1['qty'] ?></td>
                            <td valign="top" align="center"><?php echo $d1['harga_perunit'] ?></td>
                            <td valign="top" align="center"><?php echo $d1['diskon'].'%' ?></td>
                            <td valign="top" align="center"><?php echo $d1['harga_total'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td valign="top"><?php echo $data['cara_pembayaran']; ?></td>
            <td valign="top"><?php echo $data['jalur_pengiriman']; ?></td>
            <td valign="top"><?php echo $data['jenis_mu']; ?></td>
            <td valign="top"><?php echo $data['total_price']; ?></td>
            <td valign="top"><?php echo $data['total_price']*$data['ppn']/100; ?></td>
            <td valign="top"><?php echo $data['total_price_ppn']; ?></td>
        </tr>
    <?php } ?>
</table>