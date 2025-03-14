<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
?>
<!-- <label>Provinsi</label>
<select class="form-control select2" required name="provinsi" id="provinsi2" style="width: 100%;" onchange="pilihProvinsi(this.value)">
    <option value="all">Semua</option>
    <?php //$q1 = mysqli_query($koneksi, "select * from alamat_provinsi order by nama_provinsi ASC");
    //while ($row1 = mysqli_fetch_array($q1)) {
    ?>
        <option value="<?php echo $row1['id']; ?>"><?php echo $row1['nama_provinsi']; ?></option>
    <?php
    //} ?>
</select>
<br><br>
<label>Kabupaten</label>
<select class="form-control select2" name="kabupaten" id="kabupaten2" style="width: 100%;" onchange="pilihKabupaten(this.value)">
</select>
<br><br>
<label>Kecamatan</label>
<select class="form-control select2" name="kecamatan" id="kecamatan2" style="width: 100%;">
</select>
<br><br> -->
<label>Tahun</label>
<select class="form-control select2" id="tahun_now2" name="tahun_now2" style="width: 100%;">
    <?php
    $thnn = intval(date('Y'));
    for ($i=($thnn-5); $i<=$thnn; $i++) {
        ?>
        <option <?php if ($thnn == $i) {echo "selected";} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php
    }
    for ($j=$thnn+1; $j<=($thnn+5); $j++) {
        ?>
        <option <?php if ($thnn == $j) {echo "selected";} ?> value="<?php echo $j; ?>"><?php echo $j; ?></option>
        <?php
    }
    ?>
    <?php
    /*
    $q88 = mysqli_query($koneksi, "select DISTINCT year(tgl_po_pesan) as thn, max(year(tgl_po_pesan)) OVER() as maks_thn from barang_pesan group by year(tgl_po_pesan) order by year(tgl_po_pesan) ASC");
    $dd88 = mysqli_fetch_array($q88);
    while ($d = mysqli_fetch_array($q88)) {
    ?>
        <option <?php
                if (isset($_GET['thn'])) {
                    if ($_GET['thn'] != 'all') {
                        if ($_GET['thn'] == $d['thn']) {
                            echo "selected";
                        }
                    }
                } else {
                    if (!isset($_GET['pilihan'])) {
                        if (date('Y') == $d['thn']) {
                            echo "selected";
                        }
                    }
                }
                ?> value="<?php echo $d['thn']; ?>"><?php echo $d['thn']; ?></option>
    <?php } ?>
    <?php for ($i = (intval($dd88['maks_thn']) + 1); $i <= intval(date('Y')); $i++) { ?>
        <option <?php
                if (isset($_GET['thn'])) {
                    if ($_GET['thn'] != 'all') {
                        if ($_GET['thn'] == $i) {
                            echo "selected";
                        }
                    }
                } else {
                    if (!isset($_GET['pilihan'])) {
                        if (date('Y') == $i) {
                            echo "selected";
                        }
                    }
                }
                ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php } */ ?>
</select>