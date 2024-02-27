<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<table width="100%" id="" class="table table-bordered table-hover" style="background-position:center; background-repeat:no-repeat; background-size:20%; <?php if ($_SESSION['status_po'] == 0) { ?>background-image:url(img/belum%20deal.png);<?php } else { ?>background-image:url(img/sudah%20deal.png);<?php } ?>">
    <thead>
        <tr>
            <th valign="bottom">No</th>
            <th valign="bottom"><strong>Kategori</strong></th>
            <th valign="bottom"><strong>Nama Alkes</strong></th>
            <th align="center" valign="bottom"><strong>Tipe
                </strong></th>
            <th align="center" valign="bottom"><strong>Satuan
                </strong></th>
            <th align="center" valign="bottom"><strong>Harga Jual</strong></th>
            <th align="center" valign="bottom">
                <center><strong>Qty</strong></center>
            </th>
            <td align="right" valign="bottom"><strong>Total<br>(Harga_Jual*Qty)</strong></td>
            <td align="right" valign="bottom"><strong>Ongkir Per Barang</strong></td>
            <th align="center" valign="bottom" width="7%">
                <center><strong>Aksi</strong></center>
            </th>
        </tr>
    </thead>
    <!--
                      <tr>
                        <td>#</td>
                        <form method="post" name="form1" enctype="multipart/form-data">
                        <td>
                        
                        <select name="id_akse" id="id_akse" class="form-control select2" autofocus="autofocus" required onchange="changeValue(this.value)">
                          <option value="">-- Pilih Alkes --</option>
                            <?php
                            //         $q = mysqli_query($koneksi, "select * from barang_gudang order by nama_brg ASC");
                            //         $jsArray = "var dtBrg = new Array();
                            // ";
                            //         while ($d = mysqli_fetch_array($q)) { 
                            ?>
                                //         <option value="<?php echo $d['id']; ?>"><?php echo $d['nama_brg'] . " - " . $d['tipe_brg']; ?></option>
                                //         <?php
                                            //           $stok_po1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty_jual) as stok_po from barang_dijual_qty where barang_gudang_id=" . $d['id'] . ""));
                                            //           $stok_po2 = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim_detail,barang_gudang_detail,barang_dijual_qty where barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual_qty.barang_gudang_id=" . $d['id'] . ""));

                                            //           $jsArray .= "dtBrg['" . $d['id'] . "'] = {tipe_akse:'" . addslashes($d['tipe_brg']) . "',
                                            // 						merk_akse:'" . addslashes($d['merk_brg']) . "',
                                            // 						stok_total:'" . addslashes($d['stok_total'] - ($stok_po1['stok_po'] - $stok_po2)) . "',
                                            // 						harga:'" . addslashes("Rp " . number_format($d['harga_satuan'], 2, ',', '.')) . "',
                                            // 						no_akse:'" . addslashes($d['nie_brg']) . "'
                                            // 						};";
                                            //         } 
                                            ?>
                        </select>
                        
                        </td>
                        <td align="center"><input id="stok_total" name="stok_total" class="form-control" type="text" placeholder="Stok" disabled="disabled" size="4"/></td>
                        
                        <td align="center"><input id="harga" name="harga" class="form-control" type="text" placeholder="Harga" disabled="disabled" size="8"/></td>
                        <td align="center"><input id="tipe_akse" name="tipe_akse" class="form-control" type="text" placeholder="Tipe" disabled="disabled" size="15"/></td>
                        <td align="center"><input id="merk_akse" name="merk_akse" class="form-control" type="text"  placeholder="Merk" disabled="disabled" size="15"/></td>
                        <td align="center">
                          <input id="qty" name="qty" class="form-control" type="text" placeholder="" size="2"/></td>
                        <td>Auto</td>
                        <td align="center"><button name="simpan_tambah_aksesoris" class="btn btn-success" type="submit"><span class="fa fa-plus"></span> Tambah</button></td>
                        </form>
                      </tr>
                      
                      <script type="text/javascript">    
                      <?php
                        // echo $jsArray;
                        ?>  
                      function changeValue(id_akse){  
                        document.getElementById('harga').value = dtBrg[id_akse].harga;
                        document.getElementById('stok_total').value = dtBrg[id_akse].stok_total;
                        document.getElementById('tipe_akse').value = dtBrg[id_akse].tipe_akse; 
                        document.getElementById('merk_akse').value = dtBrg[id_akse].merk_akse;
                        document.getElementById('no_akse').value = dtBrg[id_akse].no_akse;
                        
                      };  
                    </script>
                    -->
    <?php
    $no = 0;
    $q_akse = mysqli_query($koneksi, "select kategori_brg, nama_brg, harga_jual_saat_itu, tipe_brg, merk_brg, qty, harga_satuan, okr, satuan, satuan_header, jumlah_rincian_to_satuan, barang_dijual_qty_hash.id as idd, barang_gudang.id as id_gudang from barang_dijual_qty_hash,barang_gudang where barang_gudang.id=barang_dijual_qty_hash.barang_gudang_id and barang_dijual_qty_hash.akun_id=" . $_SESSION['id'] . "");
    $jm = mysqli_num_rows($q_akse);
    if ($jm != 0) {
        while ($data_akse = mysqli_fetch_array($q_akse)) {
            $no++;
    ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td align="left"><?php echo $data_akse['kategori_brg']; ?>
                <td align="left"><?php echo $data_akse['nama_brg']; ?>
                </td>
                <td align="left"><?php echo $data_akse['tipe_brg']; ?></td>
                <td align="left"><?php echo $data_akse['satuan']; ?>
                    <?php
                    if ($data_akse['satuan_header'] != '') {
                        echo "<br>(" . $data_akse['jumlah_rincian_to_satuan'] . " " . $data_akse['satuan'] . "=1 " . $data_akse['satuan_header'] . ")";
                    }
                    ?>
                </td>
                <td align="left"><?php echo "Rp" . number_format($data_akse['harga_jual_saat_itu'], 2, ',', '.'); ?></td>
                <td align="center"><?php echo $data_akse['qty']; ?></td>
                <td align="right"><?php echo number_format($data_akse['harga_satuan'] * $data_akse['qty'], 2, ',', '.'); ?></td>
                <td align="right" bgcolor="#FFFF00"><?php echo "Rp" . number_format($data_akse['okr'], 2, ',', '.'); ?></td>
                <td align="center">
                    <div class="row">
                        <a href="javascript:void()" class="btn btn-xs btn-warning" onclick="ubahData('<?php echo $data_akse['idd']; ?>', '<?php echo $data_akse['qty']; ?>','<?php echo number_format($data_akse['harga_jual_saat_itu'], 0, ',', '.') ?>')">
                            <span data-toggle="tooltip" title="Ubah Kuantitas" class="fa fa-edit"></span>
                        </a>
                        <!-- <a href="index.php?page=simpan_jual_alkes2&id_hapus=<?php echo $data_akse['idd']; ?>" onclick="return confirm('Yakin Akan Menghapus Item Ini ?')"> -->
                        <a href="javascript:void()" onclick="hapus(<?php echo $data_akse['idd']; ?>)" class="btn btn-xs btn-danger">
                            <span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span>
                        </a>
                        <?php if ($data_akse['kategori_brg'] !== 'Aksesoris') { ?>
                            <br>
                            <a href="javascript:void()" class="btn btn-xs btn-info" onclick="openDetail('<?php echo $data_akse['idd']; ?>','<?php echo $data_akse['kategori_brg']; ?>', '<?php echo $data_akse['qty']; ?>')"><span data-toggle="tooltip" title="Detail" class="fa fa-folder-open-o"></span></a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
    <?php }
    } else {
        echo "<tr><td colspan='10' align='center'>Tidak Ada Data</td></tr>";
    } ?>
    <tr bgcolor="#009900">
        <td colspan="10"></td>
    </tr>
    <tr>
        <td colspan="7" align="right"><strong> Total</strong></td>
        <td align="right"><?php
                            $total1 = mysqli_fetch_array(mysqli_query($koneksi, "select sum(qty*harga_satuan) as total1 from barang_gudang,barang_dijual_qty_hash where barang_gudang.id=barang_dijual_qty_hash.barang_gudang_id and akun_id=" . $_SESSION['id'] . ""));
                            echo number_format($total1['total1'], 2, ',', '.');
                            ?></td>
        <td align="center" bgcolor="#FFFF00"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right">Total Ongkir
            <button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs" onclick="$('#ongkir').focus();"><span class="fa fa-edit"></span></button>
        </td>
        <td align="right" bgcolor="#FFFF00">
            <?php
            if (isset($_SESSION['ongkir'])) {
                $ongkir = $_SESSION['ongkir'];
                echo number_format($_SESSION['ongkir'], 2, ',', '.');
            } elseif ($_SESSION['ongkir'] == '') {
                $ongkir = 0;
                echo $ongkir;
            }
            ?>
        </td>
        <td align="center" bgcolor="#FFFF00"></td>
        <td align="center"></td>
    </tr>
    <!--
                    <tr>
                      <td colspan="6" align="right"><strong>DPP (Total+Ongkir)</strong></td>
                      <td align="right">
                        <?php
                        // if (isset($_SESSION['ongkir'])) {
                        //   $dpp = $total1['total1'] + $_SESSION['ongkir'];
                        //   echo number_format($total1['total1'] + $_SESSION['ongkir'], 2, ',', '.');
                        // } else {
                        //   echo "...";
                        // }
                        ?>
                        </td>
                      <td align="center"></td>
                    </tr>
                    -->
    <tr>
        <td colspan="7" align="right">DPP ((Total + Ongkir) /1.1)</td>
        <td align="right">
            <?php
            if (isset($_SESSION['ongkir'])) {
                $dpp = ($_SESSION['ongkir'] + $total1['total1']) / 1.1;
                echo number_format($dpp, 2, ',', '.');
            } else {
                echo "....";
            }
            ?>
        </td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right">PPN (<?php
                                            if (isset($_SESSION['ppn']) and $_SESSION['ppn'] != '') {
                                                echo $_SESSION['ppn'];
                                            } else {
                                                echo "...";
                                            }
                                            ?> %) <button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs" onclick="$('#ppn').focus();"><span class="fa fa-edit"></span></button></td>
        <td align="right">
            <?php
            if (isset($_SESSION['ppn'])) {
                $ppn = $_SESSION['ppn'] / 100 * ($dpp);
                echo number_format($ppn, 2, ',', '.');
            } else {
                echo "....";
            }
            ?>
        </td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right">PPh (<?php
                                            if (isset($_SESSION['pph']) and $_SESSION['pph'] != '') {
                                                echo $_SESSION['pph'];
                                            } else {
                                                echo "...";
                                            }
                                            ?> %) <button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs" onclick="$('#pph').focus();"><span class="fa fa-edit"></span></button></td>
        <td align="right"><?php
                            if (isset($_SESSION['pph'])) {
                                $pph = $_SESSION['pph'] / 100 * ($dpp);
                                echo number_format($pph, 2, ',', '.');
                            } else {
                                echo "....";
                            }
                            ?></td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>

    <tr>
        <td colspan="7" align="right" valign="bottom">Zakat (<?php
                                                                if ($_SESSION['zakat'] != '') {
                                                                    echo $_SESSION['zakat'];
                                                                } else {
                                                                    echo "...";
                                                                }
                                                                ?> %)<button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs" onclick="$('#zakat').focus();"><span class="fa fa-edit"></span></button></td>
        <td align="right" valign="bottom"><?php
                                            if (isset($_SESSION['zakat'])) {
                                                $zakat = $_SESSION['zakat'] / 100 * ($dpp);
                                                echo number_format($zakat, 2, ',', '.');
                                            } else {
                                                echo "....";
                                            }
                                            ?></td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right" valign="bottom">Biaya Bank <button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs" onclick="$('#biaya_bank').focus();"><span class="fa fa-edit"></span></button></td>
        <td align="right" valign="bottom"><?php
                                            if (isset($_SESSION['biaya_bank'])) {
                                                $biaya_bank = $_SESSION['biaya_bank'];
                                                echo number_format($_SESSION['biaya_bank'], 2, ',', '.');
                                            } else {
                                                echo "....";
                                            }
                                            ?></td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right" valign="bottom">
            <h4><strong>Neto (DPP(Dengan Ongkir)-(PPN dari DPP(Dengan Ongkir)+PPh dari DPP(Dengan Ongkir)+Zakat dari DPP(Dengan Ongkir)+Biaya Bank)</strong>)</h4>
        </td>
        <td align="right" valign="bottom">
            <h4><strong>
                    <?php
                    $total2 = $dpp - ($ppn + $pph + $zakat + $biaya_bank);
                    $total3 = $total2 !== 0 ? number_format($total2, 2, ',', '.') : 0;
                    echo "Rp" . number_format($total2, 2, ',', '.'); ?>
                    <script>
                        $(document).ready(function() {
                            $('#nominall').val('<?php echo $total3; ?>');
                        });
                    </script>
                </strong></h4>
        </td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right">Diskon (
            <?php
            if (isset($_SESSION['diskon']) && $_SESSION['diskon'] != '') {
                echo $_SESSION['diskon'];
            } else {
                echo "...";
            }
            ?>
            %)
            <button type="button" data-toggle="modal" data-target="#modal-ongkir1" class="btn btn-info btn-xs" onclick="$('#diskon').focus();"><span class="fa fa-edit"></span></button>
        </td>
        <td align="right"><?php
                            if (isset($_SESSION['diskon'])) {
                                $diskon = $_SESSION['diskon'];
                                echo $diskon . "%";
                            } else {
                                echo "....";
                            }
                            ?></td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <tr>
        <td colspan="7" align="right" valign="bottom"><strong>Fee Supplier (DPP(Tanpa Ongkir)-(PPN dari DPP(Tanpa Ongkir)+PPh dari DPP(Tanpa Ongkir)+Zakat dari DPP(Tanpa Ongkir)+Biaya Bank)</strong>)<strong>*Diskon</strong></td>
        <td align="right" valign="bottom">
            <strong>
                <?php
                $dpp_m = ($total1['total1'] / 1.1);
                $ppn_m = $dpp_m*$_SESSION['ppn']/100;
                $pph_m = $dpp_m * $_SESSION['pph'] / 100;
                $zakat_m = $dpp_m * $_SESSION['zakat'] / 100;
                $biaya_bank_m = $biaya_bank;
                $fee_marketing = ($dpp_m - ($ppn_m + $pph_m + $zakat_m + $biaya_bank_m)) * ($diskon / 100);
                echo "Rp" . number_format($fee_marketing, 2, ',', '.'); ?>
            </strong>
        </td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
</table>