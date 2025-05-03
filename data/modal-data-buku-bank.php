<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select *,buku_kas.id as idd from buku_kas where id = $_GET[id] order by no_akun ASC"));
?>
<input name="id" class="form-control" type="hidden" required placeholder="" value="<?php echo $data['idd']; ?>">
<label>No. Akun</label>
<input name="no_akun" class="form-control" type="text" required placeholder="" value="<?php echo $data['no_akun']; ?>"><br />
<label>Nama Akun</label>
<input name="nama_akun" class="form-control" type="text" required placeholder="" value="<?php echo $data['nama_akun']; ?>"><br />
<label>Tipe Akun</label>
<input name="akun_tipe" class="form-control" type="text" required placeholder="" readonly="readonly" value="<?php echo $data['tipe_akun']; ?>"><br />
<label>Saldo Total</label>
<input name="saldo" class="form-control" type="text" placeholder="" readonly="readonly" value="<?php echo number_format($data['saldo'], 2, ',', '.'); ?>">