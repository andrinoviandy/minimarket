<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<table align="center">
    <tr>
        <td style="padding: 10px" align="center" class="bg-info" colspan="3" width="300px"><strong>Filter</strong></td>
    </tr>
    <tr>
        <td align="right" width="45%">Merk Barang</td>
        <td width="5%" align="center">:</td>
        <td><?php echo $_GET['alkes'] ?></td>
    </tr>
    <tr>
        <td align="right" width="45%">Tipe Barang</td>
        <td width="5%" align="center">:</td>
        <td><?php echo $_GET['tipe'] ?></td>
    </tr>
    <tr>
        <td align="right">Tahun</td>
        <td align="center">:</td>
        <td><?php echo $_GET['tahun'] ?></td>
    </tr>
</table>
<br>