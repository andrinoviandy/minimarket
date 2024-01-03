<?php include("../config/koneksi.php"); ?>
<font size="+2">
    <strong>
        <?php
        $jm2 = mysqli_num_rows(mysqli_query($koneksi, "select * from stok_opname_detail_x where stok_opname_id=" . $_GET['id'] . ""));
        ?>
        <?php echo $jm2; ?>
    </strong>
</font>