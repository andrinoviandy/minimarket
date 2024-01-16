<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
?>
<input type="hidden" id="id_ubahh" value="<?php echo $_GET['id'] ?>">
<input type="hidden" id="kategorii" value="<?php echo $_GET['kategori'] ?>">
<div class="table-responsive no-padding">
    <table width="100%" id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="">No</th>
                <th width=""><strong>Nama Barang</strong></th>
                <th width="">Harga Jual</th>
                <th width="">Qty</th>
                <th width="">Total Qty</th>
                <th width="">Aksi</th>
            </tr>
        </thead>
        <?php
        // $q2 = mysqli_query($koneksi, "select *,barang_gudang_detail_set.id as idd from barang_gudang_detail_set, barang_gudang where barang_gudang.id=barang_gudang_detail_set.barang_gudang_id and barang_gudang_set_id=" . $_GET['id'] . " order by nama_brg ASC");
        $q2 = mysqli_query($koneksi, "select count(*) over() as jml , nama_brg, harga_jual_saat_itu, jml_satuan, jml_total, barang_dijual_qty_id,barang_dijual_qty_detail.id as idd, barang_dijual_qty_detail.barang_gudang_id as id_gudang from barang_dijual_qty_detail, barang_gudang where barang_gudang.id=barang_dijual_qty_detail.barang_gudang_id and barang_dijual_qty_id=" . $_GET['id'] . " order by nama_brg ASC");
        $no = 0;
        while ($d = mysqli_fetch_array($q2)) {
            $no++;
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $d['nama_brg']; ?></td>
                <td><?php echo number_format($d['harga_jual_saat_itu'], 0, '.', ','); ?></td>
                <td>
                <?php echo $d['jml_satuan']; ?>
                    <!-- <input type="number" class="form-control" value="<?php echo $d['jml_satuan']; ?>" id="qty_detail" style="width: 100px" /> -->
                </td>
                <td><?php echo number_format($d['jml_total'], 0, '.', ','); ?></td>
                <td>
                    <!-- <button class="btn btn-xs btn-info" onclick="ubahQtyDetail('<?php echo $d['idd'] ?>','<?php echo $d['barang_dijual_qty_id'] ?>')"> -->
                    <button class="btn btn-xs btn-info" onclick="modalUbahDetail('<?php echo $d['idd'] ?>','<?php echo $d['barang_dijual_qty_id'] ?>','<?php echo $_GET['kategori'] ?>', '<?php echo $d['jml_satuan']; ?>', '<?php echo $d['id_gudang']; ?>')">
                    <i class="fa fa-edit"></i> Ubah</button>
                    <button class="btn btn-xs btn-danger" onclick="hapusQtyDetail('<?php echo $d['idd'] ?>','<?php echo $d['barang_dijual_qty_id'] ?>')"><i class="fa fa-edit"></i> Hapus</button>
                </td>
            </tr>
        <?php } ?>
        <?php if ($no == 0) { ?>
            <tr>
                <td colspan="6" align="center">Data Kosong</td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="modal fade" id="modal-ubah-detail">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" align="center"><strong>Ubah Kuantitas Barang Yang Dijual</strong></h4>
            </div>
            <form method="post" id="form-ubah" enctype="multipart/form-data" onsubmit="ubahQtyDetail(); return false;">
                <div class="modal-body">
                    <input id="id_ubah_detail" type="hidden" />
                    <input id="id_gudang" type="hidden" />
                    <label>Qty</label>
                    <div class="col-lg-1">
                        <input id="qty_ubah_detail" name="qty" class="form-control" type="number" placeholder="" size="2" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="simpann" class="btn btn-success" type="submit" onclick="ubahQtyDetail(); return false;"><span class="fa fa-check"></span> Ubah</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function ubahQtyDetail(id, id_gudang) {
        let qty = $('#qty_detail').val();
        $.post("data/ubah_qty_jual_detail.php", {
                id: id,
                qty: qty,
                satuan: 'set'
            },
            function(data) {
                // $('#modal-ubah-detail').modal('hide');
                Swal.fire({
                    customClass: {
                        confirmButton: 'bg-green',
                        cancelButton: 'bg-white',
                    },
                    title: 'Berhasil Disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
                $.get("data/data_detail_jual.php", {
                        id: id_gudang
                    },
                    function(data) {
                        $('#data-detail-jual').html(data);
                        // $('#modal-detail-set').modal('show');
                    }
                );
            }
        );
    }

    function hapusQtyDetail(id, id_gudang) {
        Swal.fire({
            customClass: {
                confirmButton: 'bg-red',
                cancelButton: 'bg-white',
            },
            title: 'Anda Yakin Akan Menghapus Item Ini ?',
            text: 'Data Akan Dihapus Secara Permanen',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya , Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("data/ubah_hapus_barang_jual_detail.php", {
                        id_hapus: id
                    },
                    function(data) {
                        if (data == 'S') {
                            Swal.fire({
                                customClass: {
                                    confirmButton: 'bg-green',
                                    cancelButton: 'bg-white',
                                },
                                title: 'Berhasil Dihapus',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            });
                            $.get("data/data_detail_jual.php", {
                                    id: id_gudang
                                },
                                function(data) {
                                    $('#data-detail-jual').html(data);
                                    // $('#modal-detail-set').modal('show');
                                }
                            );
                        } else {
                            Swal.fire({
                                customClass: {
                                    confirmButton: 'bg-red',
                                    cancelButton: 'bg-white',
                                },
                                title: 'Gagal Dihapus',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                            $.get("data/data_detail_jual.php", {
                                    id: id_gudang
                                },
                                function(data) {
                                    $('#data-detail-jual').html(data);
                                    // $('#modal-detail-set').modal('show');
                                }
                            );
                        }
                    }
                );
            }
        })
    }

    function openDetail2(id, id_gudang, qty) {
        $('#id_ubah_detail').val(id);
        $('#id_gudang').val(id_gudang);
        $('#qty_ubah_detail').val(qty);
        $('#modal-ubah-detail').modal('show');
    }
</script>