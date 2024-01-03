<?php
if (isset($_GET['cari'])) {
    $jml_found = $jml;
} else {
    $jml_found = $jml_total;
}
echo "<b>Data Found : " . $jml_found . "</b>";
?>