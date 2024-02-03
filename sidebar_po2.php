<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="kharisma.png" class="" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin PO</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php include "active.php"; ?>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header"><em><strong>NAVIGASI</strong></em></li>
            <li class="<?php echo $act1; ?>">
                <a href="index.php?page=beranda">
                    <i class="fa fa-dashboard"></i> <span>Beranda</span>
                    <span class="pull-right-container">

                    </span>
                </a>
            </li>
            <li class="treeview active"><a href="#">
                    <i>(P)</i> <span><strong><em>PURCHASE ORDER</em></strong></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview <?php echo $sub_act2_pesan; ?>">
                        <a href="#"><i class="fa fa-cube"></i> <span class="">Pembelian Alkes</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo $pil1; ?>"><a href="index.php?page=pembelian_alkes" class=""><i class="fa fa-circle-o"></i> PO Dalam Negeri</a></li>
                            <li class="<?php echo $po_no_seri; ?>"><a href="index.php?page=pembelian_alkes2" class=""><i class="fa fa-circle-o"></i> PO Luar Negeri</a></li>
                            <!-- <li class="treeview <?php echo $pil2; ?>"> -->
                            <!--<a href="index.php?page=jual_akse" class="text-green"><i class="fa fa-circle-o text-green"></i> Penjualan Aksesoris</a>-->
                            <!-- <a href="#" class=""><i class="fa fa-circle-o"></i> PO Luar Negeri
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php echo $po_no_seri; ?>"><a href="index.php?page=pembelian_alkes2" class=""><i class="fa fa-circle-o"></i> Alkes Ber No Seri</a></li>

                  <li class="<?php echo $po_set; ?>"><a href="index.php?page=pembelian_alkes2_set" class=""><i class="fa fa-circle-o"></i> Alkes Ber Set</a></li>
                </ul>
              </li> -->
                            <!--
                <li class="<?php echo $admin_jual_alkes; ?>"><a href="index.php?page=admin_jual_alkes"><i class="fa fa-circle-o"></i> Admin Jual Alkes</a></li>-->

                        </ul>
                    </li>
                    <!-- <li class="treeview <?php echo $po_aksesoris; ?>">
            <a href="#"><i class="fa fa-cube"></i> <span class="">Pembelian Aksesoris</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php echo $po_aksesoris1; ?>">
                <a href="index.php?page=pembelian_akse" class=""><i class="fa fa-circle-o"></i> PO Dalam Negeri</a>
              </li>
              <li class="<?php echo $po_aksesoris2; ?>">
                <a href="index.php?page=pembelian_akse2" class=""><i class="fa fa-circle-o"></i> PO Luar Negeri</a>
              </li> -->
                    <!--
                <li class="<?php echo $admin_jual_alkes; ?>"><a href="index.php?page=admin_jual_alkes"><i class="fa fa-circle-o"></i> Admin Jual Alkes</a></li>-->
                    <!-- </ul>
          </li> -->
                    <li class="treeview <?php echo $po_inventory; ?>">
                        <a href="#"><i class="fa fa-cube"></i> <span class="">Pembelian Inventory</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo $po_inventory1; ?>">
                                <a href="index.php?page=pembelian_inventory" class=""><i class="fa fa-circle-o"></i> PO Dalam Negeri</a>
                            </li>
                            <li class="<?php echo $po_inventory2; ?>">
                                <a href="index.php?page=pembelian_inventory2" class=""><i class="fa fa-circle-o"></i> PO Luar Negeri</a>
                            </li>
                            <!--
                <li class="<?php echo $admin_jual_alkes; ?>"><a href="index.php?page=admin_jual_alkes"><i class="fa fa-circle-o"></i> Admin Jual Alkes</a></li>-->

                        </ul>
                    </li>
                    <li class="treeview <?php echo $act2_2; ?>"><a href="#">
                            <i class="fa fa-cube"></i>
                            <span>Penjualan</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo $sub_act2_2_1; ?>"><a href="index.php?page=jual_barang_uang" class=""><i class="fa fa-circle-o"></i> Alkes</a></li>
                            <!-- <li class="treeview <?php echo $sub_act2_2; ?>"> <a href="#"> <i class="fa fa-circle-o"></i> <span class="">Penjualan Alkes</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span> </a>
                <ul class="treeview-menu">
                  <li class="<?php echo $sub_act2_2_1; ?>"><a href="index.php?page=jual_barang_uang" class=""><i class="fa fa-circle-o"></i> Alkes Ber No Seri</a></li>

                  <li class="<?php echo $sub_act2_2_2; ?>"><a href="index.php?page=penjualan_barang_set" class=""><i class="fa fa-circle-o"></i> Alkes Ber Set</a></li>
                </ul>
              </li> -->
                            <!-- <li class="<?php echo $sub_act2_3; ?>"> -->
                            <!--<a href="index.php?page=jual_akse" class="text-green"><i class="fa fa-circle-o text-green"></i> Penjualan Aksesoris</a>-->
                            <!-- <a href="index.php?page=penjualan_aksesoris_uang" class=""><i class="fa fa-circle-o"></i> Penjualan Aksesoris</a>
              </li> -->
                            <li class="<?php echo $sub_act2_4; ?>">
                                <a href="index.php?page=penjualan_inventory" class=""><i class="fa fa-circle-o"></i> Inventory</a>
                            </li>
                            <!--
                <li class="<?php echo $sub_act2_4; ?>">
                <a href="index.php?page=penjualan_barang_set" class=""><i class="fa fa-circle-o"></i> Penjualan Barang Set</a>
                </li>-->
                        </ul>
                    </li>
                    <li class="treeview <?php echo $list_barang; ?>">
                        <a href="#"><i class="fa fa-cube"></i> <span class="">List Barang</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo $list_barang1; ?>">
                                <a href="index.php?page=barang_masuk" class=""><i class="fa fa-circle-o"></i> Alkes</a>
                            </li>
                            <!-- <li class="<?php echo $list_barang2; ?>">
                <a href="index.php?page=barang_set" class=""><i class="fa fa-circle-o"></i> Alkes Ber Set</a>
              </li>
              <li class="<?php echo $list_barang3; ?>">
                <a href="index.php?page=aksesoris" class=""><i class="fa fa-circle-o"></i> Aksesoris</a>
              </li> -->
                            <li class="<?php echo $list_barang4; ?>">
                                <a href="index.php?page=barang_inventory" class=""><i class="fa fa-circle-o"></i> Inventory</a>
                            </li>
                        </ul>
                    </li>
                    <!---
        <li class="<?php echo $sub_act2_1; ?>">
         <a href="index.php?page=barang_masuk_0"><i class="fa fa-cube text-green"></i> <span class="text-green">Alkes Gudang 1</span>
            <span class="pull-right-container">
              
            </span>
            </a>
        </li>-->

                </ul>
            </li>
            
            <li><a href="javascript:void()" onclick="prosesLogout();"><i class="fa fa-close"></i> <span>Logout</span></a></li>
            <!-- <li><a href="proses_logout.php" onclick="return confirm('Yakin Akan Keluar Dari Aplikasi ?')"><i class="fa fa-close"></i> <span>Logout</span></a></li> -->
            <li class="header"><strong><em>KETERANGAN</em></strong></li>
            <!--<li><a><i class="fa fa-circle-o text-aqua"></i> <span>Kerusakan Belum SPK</span></a></li>-->
            <li><a><i class="fa fa-circle-o text-green"></i> <span>Jumlah Maintenance</span></a></li>
            <li><a><i class="fa fa-circle-o text-yellow"></i> <span>Sedang Dikerjakan</span></a></li>
            <li><a><i class="fa fa-circle-o text-red"></i> <span>Belum Dikerjakan</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>