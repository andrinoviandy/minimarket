<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="img/logo.png" class="" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['nama'] ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION['waktu_login'] ?></a>
      </div>
    </div>
    <!-- search form -->

    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <?php include "active.php"; ?>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header"><strong><em>NAVIGASI</em></strong></li>
      <li class="<?php echo $produk; ?>">
        <a href="index.php?page=produk">
          <i class="fa fa-cube"></i> <span> Produk</span>
        </a>
      </li>
      <li class="<?php echo $pembelian; ?>">
        <a href="index.php?page=pembelian">
          <i class="fa fa-download"></i> <span> Pembelian</span>
        </a>
      </li>
      <li class="<?php echo $penjualan; ?>">
        <a href="index.php?page=penjualan">
          <i class="fa fa-cart-plus"></i> <span> Penjualan</span>
        </a>
      </li>
      <li class="<?php echo $pemasok; ?>">
        <a href="index.php?page=pemasok">
          <i class="fa fa-money"></i> <span>Supplier</span>
        </a>
      </li>
      <!-- <li class="<?php echo $pembeli; ?>">
        <a href="index.php?page=pembeli">
          <i class="fa fa-users"></i> <span>Pelanggan</span>
        </a>
      </li> -->
      <li style="margin-top: 30%;"></li>
      <!-- <li><a href="javascript:void()" onclick="prosesLogout();"><i class="fa fa-close"></i> <span>Logout</span></a></li> -->
      <!-- <li><a href="proses_logout.php" onclick="return confirm('Yakin Akan Keluar Dari Aplikasi ?')"><i class="fa fa-close"></i><span>Logout</span></a></li> -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>