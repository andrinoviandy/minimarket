<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
?>
<div class="row">
    <div class="col-lg-11">
        <input type="text" id="cari_produk" class="form-control" placeholder="Masukkan Keyword..." onchange="handleSearch(this.value); return false;" />
    </div>
    <div class="col-lg-1">
        <button class="btn btn-sm btn-info" onclick="reloadProduk(); return false;"><span class="fa fa-refresh"></span></button>
    </div>
</div>
<div class="table-responsive no-padding">
    <table width="100%" id="example2" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Kategori Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
            $sql = "select a.*, b.kategori from produk a left join kategori_produk b on b.id = a.kategori_produk_id where (a.nama_produk like '%$_GET[keyword]%' or b.kategori like '%$_GET[keyword]%') and a.stok != 0 order by a.nama_produk asc limit $_GET[start], $_GET[limit]";
        } else {
            $sql = "select a.*, b.kategori from produk a left join kategori_produk b on b.id = a.kategori_produk_id where a.stok != 0 order by a.nama_produk asc limit $_GET[start], $_GET[limit]";
        }
        $q = mysqli_query($koneksi, $sql);
        $nn = 0;
        while ($d1 = mysqli_fetch_array($q)) {
            $nn++;
        ?>
            <tr>
                <td><?php echo $nn; ?></td>
                <td>
                    <?php echo $d1['nama_produk']; ?>
                </td>
                <td><?php echo "Rp" . number_format($d1['harga_jual'], 0, ',', '.'); ?></td>
                <td><?php echo $d1['kategori']; ?></td>
                <td><button class="btn btn-xs btn-info" onclick="pilihProduk('<?php echo $d1['id']; ?>','<?php echo $d1['harga_jual']; ?>')">Pilih</button></td>
            </tr>
        <?php } ?>
    </table>
</div>
<center>
    <ul class="pagination">
        <button class="btn btn-default" id="produk-1" onclick="prev(); return false;"><a><i class="fa fa-angle-double-left"></i></a></button>
        <button class="btn btn-default" id="produk-2" onclick="next(); return false;"><a><i class="fa fa-angle-double-right"></i></a></button>
    </ul>
</center>