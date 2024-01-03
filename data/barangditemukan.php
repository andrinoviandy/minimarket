<?php include("../config/koneksi.php"); ?>
<font size="+2">
    <strong>
        <?php
        $jm1 = mysqli_num_rows(mysqli_query($koneksi, "select * from stok_opname_detail where stok_opname_id=" . $_GET['id'] . ""));
        ?>
        <?php echo $jm1; ?>
    </strong>
</font>