<?php
$split = explode("-", $_POST['bulan']);
$kategori = $_POST['kategori'] === 'keluar' ? "Keluar" : "Masuk";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap Barang $kategori - " . $split[1] . "/" . $split[0] . " .xls");
?>
<?php require("config/koneksi.php"); ?>
<center style="font-size: 20px;"><strong>PT. CIPTA VARIA KHARISMA UTAMA</strong></center>
<center style="font-size: 16px;"><strong>LAPORAN BARANG <?php echo $_POST['kategori'] === 'keluar' ? "KELUAR" : "MASUK" ?></strong></center>
<p><b><?php echo date("F Y", strtotime($_POST['bulan'])); ?></b></p>
<?php if ($_POST['kategori'] == 'keluar') { ?>
    <table width="" border="1" class="table table-bordered table-hover" id="example1">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama Pabrikan/Merk</th>
                <th align="center">Nama Produk</th>
                <th align="center">Nomor Ijin Edar (NIE)</th>
                <th align="center">Tipe</th>
                <th align="center">Jumlah Keluar Barang</th>
                <th align="center">No Seri</th>
                <th align="center">No Batch</th>
                <th align="center">No Loth</th>
                <th align="center">Tanggal Masuk</th>
                <th align="center">Tanggal Keluar</th>
                <th align="center">Tanggal Kadaluarsa</th>
                <th align="center">Nama Pemesan</th>
                <th align="center">Alamat Pemesan</th>
                <th align="center">Marketing</th>
            </tr>
        </thead>
        <?php
        $query = mysqli_query($koneksi, "
        select 
            c.id, c.merk_brg, c.nama_brg, c.nie_brg, c.tipe_brg, d.tgl_kirim,
            (select COUNT(aa.id) from barang_dikirim_detail aa join barang_gudang_detail bb on bb.id = aa.barang_gudang_detail_id join barang_gudang cc on cc.id = bb.barang_gudang_id join barang_dikirim dd on dd.id = aa.barang_dikirim_id where cc.id = c.id and aa.status_batal != 1 and DATE_FORMAT(dd.tgl_kirim, '%Y-%m') = '" . $_POST['bulan'] . "') as jml_keluar_brg 
        from
            barang_gudang c 
        join barang_gudang_detail a on
            c.id = a.barang_gudang_id
        join barang_dikirim_detail b on
            a.id = b.barang_gudang_detail_id 
        join barang_dikirim d on
            d.id = b.barang_dikirim_id 
        where b.status_batal != 1 and DATE_FORMAT(d.tgl_kirim, '%Y-%m') = '" . $_POST['bulan'] . "' group by c.id order by c.merk_brg asc, c.nama_brg asc;
        ");
        $jml = mysqli_num_rows($query);

        if ($jml != 0) {
            $no = 0;
            while ($data = mysqli_fetch_array($query)) {
                $no++;
        ?>
                <tr>
                    <td align="center" valign="top"><?php echo $no; ?></td>
                    <td align="left" valign="top"><?php echo $data['merk_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['nama_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['nie_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['tipe_brg']; ?></td>
                    <td align="center" valign="top"><?php echo $data['jml_keluar_brg']; ?></td>
                    <td valign="top" colspan="9">
                        <table width="100%" border="1">
                            <?php $sel = mysqli_query($koneksi, "select b.no_seri_brg, b.no_bath, b.no_lot, h.tgl_po_gudang, f.tgl_kirim, b.tgl_expired, g.nama_pembeli, g.jalan, e.marketing from barang_dikirim_detail a left join barang_gudang_detail b on b.id = a.barang_gudang_detail_id left join barang_gudang c on c.id = b.barang_gudang_id left join barang_dijual_qty d on d.id = a.barang_dijual_qty_id left join barang_dijual e on e.id = d.barang_dijual_id left join barang_dikirim f on f.id = a.barang_dikirim_id left join pembeli g on g.id = e.pembeli_id left join barang_gudang_po h on h.id = b.barang_gudang_po_id where a.status_batal !=1 and c.id = $data[id] and DATE_FORMAT(f.tgl_kirim, '%Y-%m') = '" . $_POST['bulan'] . "' order by b.no_seri_brg asc");
                            while ($data_sel = mysqli_fetch_array($sel)) {
                            ?>
                                <tr>
                                    <td align="left"><?php echo $data_sel['no_seri_brg']; ?></td>
                                    <td align="left"><?php echo $data_sel['no_bath']; ?></td>
                                    <td align="left"><?php echo $data_sel['no_lot']; ?></td>
                                    <td align="left"><?php echo $data_sel['tgl_po_gudang'] !== '0000-00-00' ? $data_sel['tgl_po_gudang'] : ''; ?></td>
                                    <td align="left"><?php echo $data_sel['tgl_kirim'] !== '0000-00-00' ? $data_sel['tgl_kirim'] : ''; ?></td>
                                    <td align="left"><?php echo $data_sel['tgl_expired'] !== '0000-00-00' ? $data_sel['tgl_expired'] : ''; ?></td>
                                    <td align="left"><?php echo $data_sel['nama_pembeli']; ?></td>
                                    <td align="left"><?php echo $data_sel['jalan']; ?></td>
                                    <td align="left"><?php echo $data_sel['marketing']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="15" align="center" valign="top">Data Tidak Ada / Kosong</td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <table width="" border="1" class="table table-bordered table-hover" id="example1">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama Pabrikan/Merk</th>
                <th align="center">Nama Produk</th>
                <th align="center">Nomor Ijin Edar (NIE)</th>
                <th align="center">Tipe</th>
                <th align="center">Tanggal Masuk</th>
                <th align="center">Jumlah Masuk Barang</th>
                <th align="center">Nama Principle</th>
                <th align="center">Alamat Principle</th>
                <th align="center">No Seri</th>
                <th align="center">No Batch</th>
                <th align="center">No Loth</th>
                <!-- <th align="center">Tanggal Keluar</th> -->
                <th align="center">Tanggal Kadaluarsa</th>
                <!-- <th align="center">Status</th> -->
            </tr>
        </thead>
        <?php
        $query = mysqli_query($koneksi, "
        select
            bgp.id, bg.merk_brg, bg.nama_brg, bg.nie_brg, bg.tipe_brg, bgp.stok as jml_masuk_brg, bgp.tgl_po_gudang, p.nama_principle, p.alamat_principle 
        from
            barang_gudang_po bgp
        join barang_pesan bp on
            bp.no_po_pesan = bgp.no_po_gudang 
        join barang_gudang bg on 
            bg.id = bgp.barang_gudang_id 
        join principle p on 
            p.id = bp.principle_id 
        where
            DATE_FORMAT(bgp.tgl_po_gudang, '%Y-%m') = '" . $_POST['bulan'] . "' order by bg.merk_brg asc, bg.nama_brg asc;
        ");
        $jml = mysqli_num_rows($query);

        if ($jml != 0) {
            $no = 0;
            while ($data = mysqli_fetch_array($query)) {
                $no++;
        ?>
                <tr>
                    <td align="center" valign="top"><?php echo $no; ?></td>
                    <td align="left" valign="top"><?php echo $data['merk_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['nama_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['nie_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['tipe_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['tgl_po_gudang'] !== '0000-00-00' ? $data['tgl_po_gudang'] : ''; ?></td>
                    <td align="center" valign="top"><?php echo $data['jml_masuk_brg']; ?></td>
                    <td align="left" valign="top"><?php echo $data['nama_principle']; ?></td>
                    <td align="left" valign="top"><?php echo $data['alamat_principle']; ?></td>
                    <td valign="top" colspan="4">
                        <table width="100%" border="1">
                            <?php $sel = mysqli_query($koneksi, "select * from barang_gudang_detail where barang_gudang_po_id = $data[id] order by no_seri_brg asc");
                            while ($data_sel = mysqli_fetch_array($sel)) {
                            ?>
                                <tr>
                                    <td align="left"><?php echo $data_sel['no_seri_brg']; ?></td>
                                    <td align="left"><?php echo $data_sel['no_bath']; ?></td>
                                    <td align="left"><?php echo $data_sel['no_lot']; ?></td>
                                    <td align="left"><?php echo $data_sel['tgl_expired'] !== '0000-00-00' ? $data_sel['tgl_expired'] : ''; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="15" align="center" valign="top">Data Tidak Ada / Kosong</td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>