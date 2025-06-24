<?php include "config/koneksi.php"; ?>
<?php
function getClientIP()
{

	if (isset($_SERVER)) {

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			return $_SERVER["HTTP_X_FORWARDED_FOR"];

		if (isset($_SERVER["HTTP_CLIENT_IP"]))
			return $_SERVER["HTTP_CLIENT_IP"];

		return $_SERVER["REMOTE_ADDR"];
	}

	if (getenv('HTTP_X_FORWARDED_FOR')) {
		return getenv('HTTP_X_FORWARDED_FOR');
	}

	if (getenv('HTTP_CLIENT_IP')) {
		return getenv('HTTP_CLIENT_IP');
	}

	return getenv('REMOTE_ADDR');
}
?>
<?php
error_reporting(0);
$user = $_POST['username'];
$pass = md5($_POST['password']);
date_default_timezone_set('Asia/Jakarta');

$query = mysqli_query($koneksi, "select * from admin, role where role.id = admin.role_id and admin.username='$user' and admin.password='$pass'");
$total_row = mysqli_num_rows($query);
$d = mysqli_fetch_array($query);
if ($total_row > 0) {
	session_start();
	$_SESSION['id'] = $d['id'];
	$_SESSION['nama'] = $d['nama'];
	$_SESSION['user'] = $user;
	$_SESSION['waktu_login'] = strval(date('d/m/Y H:i:s'));
	$_SESSION['role_id'] = $d['role_id'];
	$_SESSION['role'] = $d['nama_role'];
	$jam = date("h");
	mysqli_query($koneksi, "insert into riwayat_admin values('','$user','" . date("Y-m-d $jam:i:s") . "','')");
	$sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from riwayat_admin order by id DESC limit 1"));
	//header("location: index.php");
	$_SESSION['id_riwayat'] = $sel['id'];
	echo "S";
} else {
	echo "F";
}
?>