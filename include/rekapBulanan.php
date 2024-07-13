<button class="btn btn-info" data-toggle="modal" data-target="#modal-pencarian"><span class="fa fa-calendar"></span>&nbsp; Rekap Keluar/Masuk</button>&nbsp;&nbsp;
<div class="modal fade" id="modal-pencarian">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rekap Keluar/Masuk Barang</h4>
            </div>
            <form method="post" enctype="multipart/form-data" action="rekap_alkes_bulanan.php">
                <div class="modal-body">
                    <label>Bulan Tahun</label>
                    <input required name="bulan" type="month" class="form-control" placeholder="" value=""><br />
                    <label>Kategori</label>
                    <select class="form control select2" style="width: 100%;" name="kategori" required>
                        <option value="">...</option>
                        <option value="keluar">Barang Keluar</option>
                        <option value="masuk">Barang Masuk</option>
                    </select>
                    <br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" name="pencarian"><span class="fa fa-file-excel-o"></span> Cetak (.xls)</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>