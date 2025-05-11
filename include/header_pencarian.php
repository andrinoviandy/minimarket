<?php
if (isset($_GET['kunci']) || (isset($_GET['tgl1']) && isset($_GET['tgl2']))) {
?>
	<section class="col-lg-12">

		<div class="alert box alert-dismissible">
			<a href="?page=<?php if (isset($_GET['id'])) {
                        echo $_GET['page'] . "&id=" . $_GET['id'];
                    } else {
                        echo $_GET['page'];
                    } ?>" type="button" class="close" data-dismiss="alert" aria-hidden="true"><button>&times;</button></a>
			<h4><i class="icon fa fa-calendar"></i>Filter By Tanggal</h4>
			<h4>
				<?php
				if (isset($_GET['kunci'])) {
					echo "Kata Kunci '" . $_GET['kunci'] . "'";
				} else {
					echo "Dari Tanggal '" . tgl_indo($_GET['tgl1']) . " Sampai " . tgl_indo($_GET['tgl2']) . "'";
				}
				?></h4>
		</div>

	</section>
<?php } ?>