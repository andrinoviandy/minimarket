<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="table-responsive no-padding">
        <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="" valign="top"><strong>Tanggal</strong></th>
                    <th width="" valign="top">Nominal</th>
                    <th width="" valign="top"><strong>Deskripsi</strong></th>
                    <th width="" valign="top"> Akun</th>
                    <th width="" valign="top">Aksi</th>
                </tr>
            </thead>
            <?php
            $q2 = mysqli_query($koneksi, "select *,utang_piutang_bayar.id as idd from utang_piutang_bayar,buku_kas where buku_kas.id=utang_piutang_bayar.buku_kas_id and utang_piutang_id=$_GET[id]");
            while ($d = mysqli_fetch_array($q2)) {
            ?>
                <tr>
                    <td>
                        <?php echo date("d M Y", strtotime($d['tgl_bayar']));  ?></td>
                    <td><?php echo "Rp " . number_format($d['nominal'], 2, ',', '.'); ?>
                    </td>
    
                    <td><?php echo $d['deskripsi']; ?></td>
                    <td><?php echo $d['nama_akun']; ?></td>
                    <td>
                        <!-- <a href="index.php?page=bayar_piutang&id_hapus=<?php echo $d['idd']; ?>&id=<?php echo $_GET['id']; ?>" onclick="return confirm('Anda Yakin Akan Menghapus Riwayat Ini ?')"> -->
                        <button onclick="hapus('<?php echo $d['idd']; ?>')" class="btn btn-xs btn-danger">
                            <span data-toggle="tooltip" title="Hapus" class="ion-android-delete"></span>
                        </button>
                        &nbsp;&nbsp;
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-ubah<?php echo $d['idd']; ?>"> -->
                        <button class="btn btn-xs btn-info" onclick="modalUbah('<?php echo $_GET['id']; ?>','<?php echo $d['idd']; ?>')">
                        <span data-toggle="tooltip" title="Ubah" class="fa fa-edit"></span></button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    
    <!-- DataTables -->
    <script>
        $(function() {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': false,
                'info': false,
                'autoWidth': true
            })
            $('#example3').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': false,
                'autoWidth': true
            })
            $('#example5').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            })
            $('#example4').DataTable()
        })
    </script>
</body>
</html>