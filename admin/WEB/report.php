<?php
require '../PHP/crud-produk.php';
include '../PHP/filter-report.php';

// $rows = query("SELECT detail_transaksi.id, transaksi.kode, produk.nama_produk, detail_transaksi.kuantitas, detail_transaksi.total, transaksi.tanggal, karyawan.nama 
//                 FROM detail_transaksi 
//                 JOIN transaksi ON detail_transaksi.id = transaksi.kode
//                 JOIN karyawan ON transaksi.karyawan = karyawan.id
//                 JOIN produk ON detail_transaksi.produk_terjual = produk.kode
//               ");


$rows = query("SELECT  
                  transaksi.kode AS kode_transaksi, 
                  GROUP_CONCAT(produk.nama_produk SEPARATOR ', ') AS produk_terjual_multivalue, 
                  SUM(detail_transaksi.kuantitas) AS total_kuantitas, 
                  SUM(detail_transaksi.total) AS total_pembelian, 
                  transaksi.tanggal AS tanggal_terjual, 
                  karyawan.nama AS karyawan_melayani 
              FROM 
                  transaksi 
              JOIN detail_transaksi ON detail_transaksi.kode_transaksi = transaksi.kode
              JOIN karyawan ON transaksi.karyawan = karyawan.id
              JOIN produk ON detail_transaksi.produk_terjual = produk.kode
              GROUP BY 
                  transaksi.kode, 
                  transaksi.tanggal, 
                  karyawan.nama
              ORDER BY 
                  transaksi.kode DESC;
              ");


// if ( isset($_POST["filter"]) ){
//   $data_brg = filter();
// } else {
//   $data_brg = null;
// }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>Dashboard</title>

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="../CSS/style-report.css"
    />
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- Navigasi -->
    <nav class="navbar">
      <h1>INVENTORY SYSTEM</h1>
      <div class="container-dashboard">
        <span class="icon"><i data-feather="home"></i></span>
        <a
          href="index.php"
          class="menu-nav dashboard"
          >Dashboard</a
        >
      </div>
      <div class="container-produk">
        <span class="icon"><i data-feather="shopping-cart"></i></span>
        <a
          href="produk.php"
          class="menu-nav"
          >Produk</a
        >
      </div>
      </div>
      <div class="container-karyawan">
        <span class="icon"><i data-feather="users"></i></span>
        <a
          href="karyawan.php"
          class="menu-nav"
          >Karyawan</a
        >
      </div>
      <div class="container-transaksi">
          <span class="icon"><i data-feather="dollar-sign"></i></span>
          <a
            href="transaksi.php"
            class="menu-nav"
            >Transaksi</a
          >
        </div>
        <div class="container-report">
          <span class="icon utama"><i data-feather="file-text"></i></span>
          <a
            href="#"
            class="menu-nav"
            >Report</a
          >
      </div>
      <div class="container-promosi">
        <span class="icon"><i data-feather="table"></i></span>
        <a
          href="data_proses.php"
          class="menu-nav"
          >Data Proses</a
        >
      </div>
      <div class="container-akun">
        <span class="icon"><i data-feather="user"></i></span>
        <a
          href="akun.php"
          class="menu-nav"
          >Akun</a
        >
      </div>
    </nav>
    <!-- Navigasi End -->

    <!-- Profile -->
    <header class="profile">
      <h2>FreshFruit</h2>
      <h1 style="margin-right: 90px">LAPORAN TRANSAKSI</h1>
      <a
        href="akun.php"
        id="profile"
        ><i data-feather="user"></i
      ></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

    <!-- Section Detail Laporan Start -->
    <section class="container-detail-transaksi">
      <div class="icon">
        <div class="keterangan">
          <span id="feather-icon"><i data-feather="table"></i></span>
          <span>LAPORAN TRANSAKSI</span>
        </div>
      </div>

      <div class="c_periode">
        <h4>Choose Period</h4>
        <form
          action=""
          method="post"
          class="range-period"
        >
          <input
            type="date"
            id="range-start"
            name="range-start"
            placeholder="Start Date"
          />
          <label>&gt;</label>
          <input
            type="date"
            id="range-end"
            name="range-end"
            placeholder="End Date"
          />
          <button
            type="submit"
            class="report-button"
            name="filter"
            id="btnFilter"
          >
            Generate Report
          </button>
        </form>
      </div>
      
      <?php if ( isset($_POST["filter"]) ) : ?>
        <?php $data_brg = filter(); ?>
          <?php if ($data_brg != null) :?>
          <div class="kolom kolom-report">
            <table class="tabel periode">
              <thead>
                <tr>
                  <th>Periode Penjualan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><b><?= $_POST['range-start'] ?></b> Sampai Dengan <b><?= $_POST['range-end'] ?></b></td>
                </tr>
              </tbody>
            </table>
            <table class="tabel tb_detail_transaksi">
              <tr>
                <th>Produk Terjual</th>
                <th>Selling Price</th>
                <th>Buying Price</th>
                <th>Kuantitas</th>
                <th>Total</th>
              </tr>
              <?php  $id = 0;  ?>
              <?php if ($data_brg !== null) : ?>
                <?php foreach ($data_brg as $brg) :?>
                <tr>
                  <td><?= $brg['nama_produk'] ?></td>
                  <td><?= $brg['harga'] ?></td>
                  <td><?= $brg['harga_grosir'] ?></td>
                  <td><?= $brg['total_kuantitas'] ?></td>
                  <td><?= $brg['total_penjualan'] ?></td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>

              <?php
              $grand_total_penjualan = 0;
              $total_profit = 0;

              foreach ($data_brg as $item) {
                $grand_total_penjualan += $item['grand_total_penjualan'];
                $total_profit += $item['total_profit'];
              }
              ?>
              <tr style="background-color: rgb(245, 245, 245); font-weight: bold">
                <td
                  colspan="3"
                  style="text-align: center"
                ></td>
                <td style="text-align: center">Grand Total</td>
                <td style="text-align: center">Rp. <?= $grand_total_penjualan ?></td>
              </tr>

              <tr style="background-color: rgb(245, 245, 245); font-weight: bold">
                <td
                  colspan="3"
                  style="text-align: center"
                ></td>
                <td style="text-align: center">Profit</td>
                <td style="text-align: center">Rp. <?= $total_profit ?></td>
              </tr>
            </table>
          </div>
          
          <?php else : ?>
            <div class="kolom-data-null">
              <span><h4>Belum ada transaksi pada rentang tanggal yang ditentukan</h4></span>
            </div>
        <?php endif ?>
      <?php endif; ?>
    </section>
    <!-- Section Detail Laporan End -->

    <!-- Section Prediksi Permintaan Start -->
    <!-- <section class="container-prediksi-permintaan">
      <div class="icon">
        <div class="keterangan">
          <span id="feather-icon"><i data-feather="table"></i></span>
          <span>PREDIKSI PERMINTAAN</span>
        </div>
      </div>

      <div class="kolom">
        <table class="tabel tb_prediksi_permintaan">
          <tr>
            <th>Kode</th>
            <th>Prediksi Tanggal</th>
            <th>Produk</th>
            <th>Jumlah Permintaan Stok</th>
          </tr>
        </table>
      </div>
    </section> -->
    <!-- Section Prediksi Permintaan End -->

    <script>
      feather.replace();
    </script>

    <script src="../JAVASCRIPT/transaksi.js"></script>
  </body>
</html>
