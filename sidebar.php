<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="img/logo.png" class="" alt="User Image">
      </div>
      <div class="pull-left info">
        <p class="text-nowrap"><?php echo $_SESSION['nama'] . " (" . $_SESSION['role'] . ")" ?></p>
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
      <li class="<?php echo $piutang; ?>">
        <a href="index.php?page=piutang">
          <i class="fa fa-file"></i> <span> Piutang</span>
        </a>
      </li>
      <li class="<?php echo $arus_kas; ?>">
        <a href="index.php?page=arus_kas">
          <i class="fa fa-exchange"></i> <span> Arus Kas</span>
        </a>
      </li>
      <li class="<?php echo $pemasok; ?>">
        <a href="index.php?page=pemasok">
          <i class="fa fa-users"></i> <span>Supplier</span>
        </a>
      </li>
      <li class="treeview <?php echo $laporan; ?>">
        <a href="#">
          <i class="fa fa-bar-chart"></i> <span>Laporan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=laporan_pembelian" class=""><i class="fa fa-circle-o"></i> Pembelian</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=laporan_pembelian" class=""><i class="fa fa-circle-o"></i> Penjualan</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=stok_limit" class=""><i class="fa fa-circle-o"></i> Stok Limit</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=produk_kadaluarsa" class=""><i class="fa fa-circle-o"></i> Produk Kadaluarsa</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=produk_terlaris" class=""><i class="fa fa-circle-o"></i> Produk Terlaris</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=stok_harian" class=""><i class="fa fa-circle-o"></i> Stok Harian</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=laporan_piutang" class=""><i class="fa fa-circle-o"></i> Piutang</a></li>
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=laporan_laba_rugi" class=""><i class="fa fa-circle-o"></i> Laba Rugi</a></li>
        </ul>
      </li>
      <li class="treeview <?php echo $pengaturan; ?>">
        <a href="#">
          <i class="fa fa-cog"></i> <span>Pengaturan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $user; ?>"><a href="index.php?page=user" class=""><i class="fa fa-circle-o"></i> Manage User</a></li>
        </ul>
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