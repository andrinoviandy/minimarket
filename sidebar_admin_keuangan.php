<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="kharisma.png" class="" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Admin Keuangan</p>
        <a href="#"><i class="fa fa-circle text-success"></i> <?php
                                                              $sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from akun_admin_keuangan where id=" . $_SESSION['id'] . ""));
                                                              echo $sel['nama'];
                                                              ?></a>
      </div>
    </div>
    <!-- search form -->

    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <?php include "active.php"; ?>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header"><strong><em>NAVIGASI</em></strong></li>
      <li class="<?php echo $act1; ?>">
        <a href="index.php?page=beranda">
          <i class="fa fa-dashboard"></i> <span>Beranda</span>
          <span class="pull-right-container">

          </span>
        </a>
      </li>
      <li class=" <?php echo $bagian_keuangan; ?>"><a href="#"><span><strong style="color:#CC0"><em>KEUANGAN</em></strong></span><span class="pull-right-container">
          </span></a></li>

      <li class="<?php echo $ringkasan; ?>">
        <a href="index.php?page=ringkasan">
          <i class="fa fa-map"></i> <span>RINGKASAN</span>
        </a>
      </li>
      <li class="<?php echo $buku_bank; ?>">
        <a href="index.php?page=buku_bank">
          <i class="fa fa-bank"></i> <span>Rekening BANK</span>
          <span class="pull-right-container">

          </span>
        </a>
      </li>
      <li class="<?php echo $buku_kas; ?>">
        <a href="index.php?page=buku_kas">
          <i class="fa fa-book"></i> <span>Akun Kas</span>
          <span class="pull-right-container">

          </span>
        </a>
      </li>
      <li class="<?php echo $biaya_lain; ?>">
        <a href="index.php?page=biaya_lain">
          <i class="fa fa-money"></i> <span>Penerimaan & Pembayaran</span>
        </a>
      </li>
      <li class="treeview <?php echo $utang_piutang; ?>">
        <a href="#">
          <i class="fa fa-bank"></i> <span>Bayar Hutang / Piutang</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview <?php echo $dagang; ?>">
            <a href="#"><i class="fa fa-circle-o"></i>Alkes<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span></a>
            <ul class="treeview-menu">
              <li class="<?php echo $utang; ?>"><a href="index.php?page=utang" class=""><i class="fa fa-circle-o"></i> Hutang</a></li>
              <li class="<?php echo $piutang; ?>">
                <a href="index.php?page=piutang" class=""><i class="fa fa-circle-o"></i> Piutang</a>
              </li>
              <!-- <li class="treeview <?php echo $utang_piutang1; ?>">
                    <a href="#"><i class="fa fa-circle-o"></i>Alkes Ber No Seri<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span></a>
                    <ul class="treeview-menu">
                      <li class="<?php echo $utang; ?>"><a href="index.php?page=utang" class=""><i class="fa fa-circle-o"></i> Hutang</a></li>
                      <li class="<?php echo $piutang; ?>">
                        <a href="index.php?page=piutang" class=""><i class="fa fa-circle-o"></i> Piutang</a>
                      </li>
                    </ul>
                  </li>
                  <li class="treeview <?php echo $utang_piutang1_1; ?>">
                    <a href="#"><i class="fa fa-circle-o"></i>Alkes Ber Set<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span></a>
                    <ul class="treeview-menu">
                      <li class="<?php echo $utang_set; ?>"><a href="index.php?page=utang_set" class=""><i class="fa fa-circle-o"></i> Hutang</a></li>
                      <li class="<?php echo $piutang_set; ?>">
                        <a href="index.php?page=piutang_set" class=""><i class="fa fa-circle-o"></i> Piutang</a>
                      </li>
                    </ul>
                  </li>
                  <li class="treeview <?php echo $utang_piutang2; ?>">
                    <a href="#"><i class="fa fa-circle-o"></i>Aksesoris<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span></a>
                    <ul class="treeview-menu">
                      <li class="<?php echo $utang_akse; ?>"><a href="index.php?page=utang_aksesoris" class=""><i class="fa fa-circle-o"></i> Hutang</a></li>
                      <li class="<?php echo $piutang_akse; ?>">
                        <a href="index.php?page=piutang_aksesoris" class=""><i class="fa fa-circle-o"></i> Piutang</a>
                      </li>
                    </ul>
                  </li> -->
            </ul>
          </li>
          <li class="treeview <?php echo $inventoris; ?>">
            <a href="#"><i class="fa fa-circle-o"></i>Inventory<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span></a>
            <ul class="treeview-menu">
              <li class="<?php echo $inventoris1; ?>"><a href="index.php?page=utang_inventory" class=""><i class="fa fa-circle-o"></i> Hutang</a></li>
              <li class="<?php echo $inventoris2; ?>">
                <a href="index.php?page=piutang_inventory" class=""><i class="fa fa-circle-o"></i> Piutang</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="<?php echo $deposit; ?>">
        <a href="index.php?page=deposit">
          <i class="fa fa-refresh"></i> <span>Transfer Antar Kas & Bank</span>
          <span class="pull-right-container">

          </span>
        </a>
      </li>
      <li class="<?php echo $reimburse; ?>">
        <!--<a href="index.php?page=reimburse">-->
        <a href="#" data-toggle="modal" data-target="#modal-tidak">
          <i class="fa fa-briefcase"></i> <span>Reimburse</span>
        </a>
      </li>
      <!--
          <li class="treeview <?php echo $utang_piutang; ?>">
          <a href="#">
            <i class="fa fa-bank"></i> <span>Kas Bank</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <li class="<?php echo $utang; ?>"><a href="index.php?page=utang" class=""><i class="fa fa-circle-o"></i> Pembayaran</a></li>
                <li class="<?php echo $piutang; ?>">
                <a href="index.php?page=piutang" class=""><i class="fa fa-circle-o"></i> Penerimaan</a>
                </li>
          </ul>
          </li>-->
      <li class="treeview <?php echo $sub_act2_1; ?>">
        <a href="#"><i class="fa fa-cube"></i> <span class="">Persediaan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $sub_act2_1_1_0; ?>"><a href="index.php?page=barang_masuk" class=""><i class="fa fa-cube"></i> Alkes</a></li>
          <!-- <li class="treeview <?php echo $sub_act2_1_1; ?>">
                <a href="#"><i class="fa fa-cube"></i> <span class="">Alkes</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php echo $sub_act2_1_1_0; ?>"><a href="index.php?page=barang_masuk" class=""><i class="fa fa-circle-o"></i> Alkes Ber No Seri</a></li>

                  <li class="<?php echo $ber_set; ?>"><a href="index.php?page=barang_set" class=""><i class="fa fa-circle-o"></i> Alkes Ber Set</a></li>
                </ul>
              </li>

              <li class="<?php echo $sub_act2_1_2; ?>"> <a href="index.php?page=aksesoris"> <i class="fa fa-cube"></i> <span class="">Aksesoris</span> <span class="pull-right-container"> </span> </a> </li> -->
          <li class="<?php echo $sub_act2_1_3; ?>"> <a href="index.php?page=barang_inventory"> <i class="fa fa-cube"></i> <span class="">Barang Inventory</span> <span class="pull-right-container"> </span> </a> </li>
          <!--
            <li class="<?php echo $sub_act2_1_3; ?>"> <a href="index.php?page=barang_set"> <i class="fa fa-cube"></i> <span class="">Barang Set</span> <span class="pull-right-container"> </span> </a> </li>
            -->
        </ul>
      </li>
      <li class="treeview <?php echo $pembelian; ?>">
        <a href="#">
          <i class="fa fa-download"></i> <span> Pembelian</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $pembelian1_1; ?>"><a href="index.php?page=barang_gudang1" class=""><i class="fa fa-circle-o"></i> Alkes</a></li>
          <!-- <li class="treeview <?php echo $pembelian1; ?>"> <a href="#"> <i class="fa fa-circle-o"></i> <span class=""> Alkes</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span> </a>
                <ul class="treeview-menu">
                  <li class="<?php echo $pembelian1_1; ?>"><a href="index.php?page=barang_gudang1" class=""><i class="fa fa-circle-o"></i> Alkes Ber No Seri</a></li>

                  <li class="<?php echo $pembelian1_2; ?>"><a href="index.php?page=barang_set1" class=""><i class="fa fa-circle-o"></i> Alkes Ber Set</a></li>
                </ul>
              </li> -->
          <!-- <li class="<?php echo $pembelian2; ?>"> -->
          <!--<a href="index.php?page=jual_akse" class="text-green"><i class="fa fa-circle-o text-green"></i> Penjualan Aksesoris</a>-->
          <!-- <a href="index.php?page=aksesoris1" class=""><i class="fa fa-circle-o"></i> Aksesoris</a> -->
          <!-- </li> -->
          <li class="<?php echo $pembelian3; ?>"><!--<a href="index.php?page=jual_akse" class="text-green"><i class="fa fa-circle-o text-green"></i> Penjualan Aksesoris</a>-->
            <a href="index.php?page=barang_inventory1" class=""><i class="fa fa-circle-o"></i> Inventory</a>
          </li>

        </ul>
      </li>
      <li class="treeview <?php echo $act2_2; ?>"><a href="#">
          <i class="fa fa-cart-plus"></i>
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
      <li class="treeview <?php echo $kirim_barang_uang; ?>">
        <a href="#">
          <i class="fa fa-upload"></i> <span>Pengiriman</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $kirim_barang_uang1_1; ?>"><a href="index.php?page=kirim_barang" class=""><i class="fa fa-circle-o"></i> Alkes</a></li>
          <!-- <li class="treeview <?php echo $kirim_barang_uang1; ?>"> <a href="#"> <i class="fa fa-circle-o"></i> <span class="">Pengiriman Alkes</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span> </a>
                <ul class="treeview-menu">
                  <li class="<?php echo $kirim_barang_uang1_1; ?>"><a href="index.php?page=kirim_barang" class=""><i class="fa fa-circle-o"></i> Alkes Ber No Seri</a></li>

                  <li class="<?php echo $kirim_barang_uang1_2; ?>"><a href="index.php?page=kirim_barang_set" class=""><i class="fa fa-circle-o"></i> Alkes Ber Set</a></li>
                </ul>
              </li> -->
          <!-- <li class="<?php echo $kirim_barang_uang2; ?>"> -->
          <!--<a href="index.php?page=jual_akse" class="text-green"><i class="fa fa-circle-o text-green"></i> Penjualan Aksesoris</a>-->
          <!-- <a href="index.php?page=pengiriman_aksesoris" class=""><i class="fa fa-circle-o"></i> Pengiriman Aksesoris</a>
              </li> -->
          <li class="<?php echo $kirim_barang_uang3; ?>"><!--<a href="index.php?page=jual_akse" class="text-green"><i class="fa fa-circle-o text-green"></i> Penjualan Aksesoris</a>-->
            <a href="index.php?page=kirim_inventory_uang" class=""><i class="fa fa-circle-o"></i> Inventory</a>
          </li>
          <!--
                <li class="<?php echo $kirim_barang_uang3; ?>"><a href="index.php?page=pengiriman_barang_set" class=""><i class="fa fa-circle-o"></i> Pengiriman Barang Set</a>
                </li>-->
        </ul>
      </li>
      <li class="<?php echo $monitoring_penjualan; ?>">
        <a href="index.php?page=monitoring_penjualan">
          <i class="fa fa-bar-chart"></i> <span>Monitoring Penjualan</span>
        </a>
      </li>
      <li class="<?php echo $karyawan; ?>">
        <a href="index.php?page=karyawan">
          <i class="fa fa-user-plus"></i> <span>Karyawan</span>
        </a>
      </li>
      <li class="<?php echo $slip_gaji; ?>">
        <a href="index.php?page=gaji_karyawan">
          <i class="fa fa-bookmark"></i> <span>Slip Gaji</span>
        </a>
      </li>
      <li class="<?php echo $pemasok; ?>">
        <a href="index.php?page=pemasok">
          <i class="fa fa-money"></i> <span>Pemasok</span>
        </a>
      </li>
      <li class="<?php echo $pembeli; ?>">
        <a href="index.php?page=pembeli">
          <i class="fa fa-users"></i> <span>Pelanggan</span>
        </a>
      </li>
      <!--
          <li class="treeview <?php echo $kontrak; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Kontrak</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <li class="<?php echo $kontrak1; ?>"><a href="index.php?page=dokumen_kontrak" class=""><i class="fa fa-circle-o"></i> Dokumen</a></li>
                <li class="<?php echo $kontrak2; ?>">
                <a href="index.php?page=tagihan_kontrak" class=""><i class="fa fa-circle-o"></i> Tagihan</a>
                </li>
                <li class="<?php echo $kontrak3; ?>">
                <a href="index.php?page=pembayaran_kontrak" class=""><i class="fa fa-circle-o"></i> Pembayaran</a>
                </li>
          </ul>
          </li>
          <!--
          <li>
          <a href="index.php?page=nota_debit">
            <i class="fa fa-flask"></i> <span>Nota Debit</span>
          </a></li>
          <li>
          <a href="index.php?page=nota_kredit">
            <i class="fa fa-compass"></i> <span>Nota Kredit</span>
          </a></li>-->
      <li class="treeview <?php echo $laporan_kas; ?>">
        <a href="#">
          <i class="fa fa-bar-chart"></i> <span>Laporan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $laporan_neraca; ?>"><a href="index.php?page=laporan_neraca" class=""><i class="fa fa-circle-o"></i> Neraca</a></li>
          <li class="<?php echo $laporan_laba_rugi; ?>">
            <a href="index.php?page=laporan_laba_rugi" class=""><i class="fa fa-circle-o"></i> Laba Rugi</a>
          </li>
        </ul>
      </li>
      <!--
          <li class="treeview <?php echo $laporan_kas; ?>">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span>Laporan Kas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <li class="<?php echo $harian; ?>"><a href="index.php?page=laporan_kas_harian" class=""><i class="fa fa-circle-o"></i> Harian</a></li>
                <li class="<?php echo $bulanan; ?>">
                <a href="index.php?page=laporan_kas_bulanan" class=""><i class="fa fa-circle-o"></i> Bulanan</a>
                </li>
                <li class="<?php echo $tahunan; ?>">
                <a href="index.php?page=laporan_kas_tahunan" class=""><i class="fa fa-circle-o"></i> Tahunan</a>
                </li>
          </ul>
          </li>
          -->
      <li class="treeview <?php echo $pengaturan_akun; ?>">
        <a href="#">
          <i class="fa fa-cog"></i> <span>Pengaturan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $kategori; ?>"><a href="index.php?page=kategori" class=""><i class="fa fa-circle-o"></i> Akun COA</a></li>
          <li class="<?php echo $marketing; ?>"><a href="index.php?page=marketing" class=""><i class="fa fa-circle-o"></i> Marketing</a></li>
          <li class="<?php echo $mata_uang; ?>"><a href="index.php?page=mata_uang" class=""><i class="fa fa-circle-o"></i> Mata Uang</a></li>
          <li class="<?php echo $master_gaji; ?>"><a href="index.php?page=master_gaji" class=""><i class="fa fa-circle-o"></i> Master Gaji</a></li>
          <!--
                <li class="<?php echo $riwayat_pemasukan; ?>">
                <a href="index.php?page=riwayat_pemasukan" class=""><i class="fa fa-circle-o"></i> Riwayat Pemasukan</a>
                </li>
                <li class="<?php echo $riwayat_pengeluaran; ?>">
                <a href="index.php?page=riwayat_pengeluaran" class=""><i class="fa fa-circle-o"></i> Riwayat Pengeluaran</a>
                </li>-->

        </ul>
      </li>
      <!--<li class="<?php echo $act_pengeluaran; ?>"> <a href="index.php?page=pengeluaran"> <i class="fa fa-calculator"></i> <span>Pengeluaran</span></a></li>
        
        <li class="<?php echo $act_aksesoris_alkes; ?>"> <a href="index.php?page=aksesoris_alkes"> <i class="fa fa-gears"></i> <span>Spare Part Alkes</span> <span class="pull-right-container"> </span> </a></li>
        -->
      <!--<li class="<?php echo $act_penyebaran_alkes; ?>"> <a href="index.php?page=penyebaran_alkes"> <i class="fa fa-wifi"></i> <span>Penyebaran Alkes</span></a></li>-->
      <!--<li class="<?php echo $act_import_alkes; ?>">
          <a href="index.php?page=import_data">
            <i class="fa fa-upload"></i> <span>Import Data Gudang</span>
            <span class="pull-right-container">
              
            </span>
          </a></li>-->
      <!--<li class="header">INVOICE</li>
        <li class="<?php //echo $act3; 
                    ?>">
          <a href="index.php?page=uji_fungsi_instalasi">
            <i class="fa fa-sticky-note-o"></i> <span>Invoice Barang</span>
            <span class="pull-right-container">
              
            </span>
          </a></li>-->
      <!--<li class="header">ALKES (MASUK - JUAL - KIRIM)</li>
        <li class="treeview <?php //echo $act2; 
                            ?>">
        <a href="#">
            <i class="fa fa-adjust"></i> <span>Master Alkes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
        <li class="<?php //echo $sub_act2_1; 
                    ?>">
         <a href="index.php?page=barang_masuk"><i class="fa fa-cube text-green"></i> <span class="text-green">Alkes Masuk</span>
            <span class="pull-right-container">
              
            </span>
            </a>
        </li>
        <li class="<?php //echo //$sub_act2_2; 
                    ?>">
          <a href="index.php?page=jual_barang">
            <i class="fa fa-cube text-aqua"></i> <span class="text-aqua">Jual Alkes </span>
            <span class="pull-right-container">
              
            </span>
            </a>
        </li>
        <li class="<?php //echo $sub_act2_3; 
                    ?>">
          <a href="index.php?page=kirim_barang">
            <i class="fa fa-cube text-yellow"></i> <span class="text-yellow">Pengiriman Alkes </span>
            <span class="pull-right-container">
              
            </span>
            </a>
        </li>
        </ul>
        </li>-->
      <li><a href="javascript:void()" onclick="prosesLogout();"><i class="fa fa-close"></i> <span>Logout</span></a></li>
      <!-- <li><a href="proses_logout.php" onclick="return confirm('Yakin Akan Keluar Dari Aplikasi ?')"><i class="fa fa-close"></i><span>Logout</span></a></li> -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>