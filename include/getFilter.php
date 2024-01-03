<?php
if (isset($_POST['pencarian'])) {
    echo "<script>window.location='index.php?page=$_GET[page]&tgl1=$_POST[tgl1]&tgl2=$_POST[tgl2]&tampil=$_POST[tampil]'</script>";
}
?>
<button class="btn btn-info" data-toggle="modal" data-target="#modal-pencarian"><span class="fa fa-calendar"></span>&nbsp; Filter By Tanggal</button>&nbsp;&nbsp;
<?php if (isset($_GET['tgl1'])) { ?>
    <a href="?page=jual_barang_uang"><button class="btn btn-info"><span class="fa fa-refresh"></span> Reset</button></a>&nbsp;&nbsp;
<?php } ?>
<div class="modal fade" id="modal-pencarian">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter By Tanggal</h4>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <label>Dari Tanggal</label>
                    <input required name="tgl1" type="date" class="form-control" placeholder="" value=""><br />
                    <label>Sampai Tanggal</label>
                    <input required name="tgl2" type="date" class="form-control" placeholder="" value="">

                    <br />
                    <select name="tampil" class="form-control select2" style="width:100%">
                        <option value="">...</option>
                        <option value="1">Tampilkan Detail Barang</option>
                        <option value="0">Jangan Tampilkan Detail Barang</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" name="pencarian">Filter</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>