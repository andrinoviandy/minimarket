<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,barang_teknisi.id as idd from barang_dikirim,barang_teknisi,barang_teknisi_detail,barang_dikirim_detail,barang_gudang,barang_gudang_detail,barang_dijual,barang_dijual_qty,pembeli where barang_teknisi.id=barang_teknisi_detail.barang_teknisi_id and barang_dikirim_detail.id=barang_teknisi_detail.barang_dikirim_detail_id and barang_dikirim.id=barang_dikirim_detail.barang_dikirim_id and barang_gudang_detail.id=barang_dikirim_detail.barang_gudang_detail_id and barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_dijual_qty.id=barang_dikirim_detail.barang_dijual_qty_id and barang_dijual.id=barang_dijual_qty.barang_dijual_id and pembeli.id=barang_dijual.pembeli_id and barang_teknisi.id = " . $_GET['id'] . ""))
?>
<form method="post" enctype="multipart/form-data" onsubmit="simpanUbahSpi(); return false;">
    <div class="modal-body">
        <p align="justify">
            <input type="hidden" value="<?php echo $data['idd']; ?>" id="id_spk" name="id_spk" />
            <label>Tanggal SPI</label>
            <input id="tgl_spk" type="date" placeholder="" name="tgl_spk" class="form-control" value="<?php echo $data['tgl_spk']; ?>" required>
            <label>Nomor SPI</label>
            <input id="no_spk" type="text" value="<?php echo $data['no_spk']; ?>" class="form-control" placeholder="No SPI" name="no_spk" required>
            <label>Deskripsi</label>
            <textarea rows="4" class="form-control" name="keterangan_spk" id="keterangan_spk"><?php echo $data['keterangan_spk']; ?></textarea>
        </p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button class="btn btn-success" name="jual" type="submit">Simpan Perubahan</button>
    </div>
</form>
<script>
    function simpanUbahSpi() {
        $.post("data/simpan-ubah-spi.php", {
                id_spk: $('#id_spk').val(),
                tgl_spk: $('#tgl_spk').val(),
                no_spk: $('#no_spk').val(),
                keterangan_spk: $('#keterangan_spk').val()
            },
            function(data) {
                if (data == 'S') {
                    $('#modal-ubah').modal('hide');
                    alertSimpan('S');
                    loadMore(load_flag, key, status_b)
                } else {
                    alertSimpan('F');
                }
            }
        );
    }
</script>