<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$d = mysqli_fetch_array(mysqli_query($koneksi, "select *,utang_piutang_bayar.id as idd from utang_piutang_bayar,buku_kas where buku_kas.id=utang_piutang_bayar.buku_kas_id and utang_piutang_bayar.id=$_GET[id_ubah]"));
?>
<p align="justify">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
    <input type="hidden" name="id_ubah" value="<?php echo $_GET['id_ubah']; ?>" />
    <label>Tanggal</label>
    <input name="tgl_input2" class="form-control" type="date" placeholder="" required="required" value="<?php echo $d['tgl_bayar']; ?>"><br />
    <label>Nominal</label>
    <input name="nominal2" class="form-control" type="text" placeholder="" required="required" value="<?php echo number_format($d['nominal'], 0, ',', '.'); ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br />
    <label>Deskripsi</label>
    <textarea name="deskripsi2" class="form-control" rows="4" required="required"><?php echo $d['deskripsi']; ?></textarea>
    <br />

    <label>Akun</label>
    <select name="akun2" id="akun2" class="form-control select2" required style="width:100%">
        <option value="">-- Pilih --</option>
        <?php
        $q = mysqli_query($koneksi, "select * from buku_kas order by no_akun ASC");
        while ($d2 = mysqli_fetch_array($q)) {
        ?>
            <option <?php if ($d['buku_kas_id'] == $d2['id']) {
                        echo "selected";
                    } ?> value="<?php echo $d2['id']; ?>"><?php echo $d2['no_akun'] . " | &nbsp;&nbsp;" . $d2['nama_akun']; ?></option>
        <?php } ?>
    </select><br />
</p>