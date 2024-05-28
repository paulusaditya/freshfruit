<?php
require '../PHP/crud-produk.php';
include '../PHP/transaksi.php';

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

if ( isset($_POST["cari"]) ){
  $rows = cari_transaksi($_POST['keyword']);
}


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
      href="../CSS/style-transaksi.css"
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
          <span class="icon utama"><i data-feather="dollar-sign"></i></span>
          <a
            href="#"
            class="menu-nav"
            >Transaksi</a
          >
        </div>
        <div class="container-report">
          <span class="icon"><i data-feather="file-text"></i></span>
          <a
            href="report.php"
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
      <h1 style="margin-right: 90px">TRANSAKSI</h1>
      <a
        href="akun.php"
        id="profile"
        ><i data-feather="user"></i
      ></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

    <!-- Kolom Manajemen Transaksi Start -->
    <section class="container-manajemen-transaksi">
      <div class="icon">
        <div class="keterangan">
          <span id="feather-icon"><i data-feather="table"></i></span>
          <span>TRANSAKSI</span>
        </div>
      </div>

      <!-- Fitur Search and Sort Start -->
      <!-- Pencarian Start -->
      <div class="fitur-tambahan">
        <div class="pencarian">
          <form
            action=""
            method="post"
          >
            <input
              type="text"
              name="keyword"
              placeholder="Search Product"
              autocomplete="off"
              required
            />
            <button
              type="submit"
              name="cari"
            >
              Search
            </button>
            <div class="refresh">
              <a href="transaksi.php"><i data-feather="refresh-ccw"></i></a>
            </div>
          </form>
        </div>
      </div>
      <!-- Fitur Search nd Sort End -->

      <div class="kolom">
        <table class="tb_transaksi">
          <tr>
            <th>Kode Transaksi</th>
            <th>Produk Terjual</th>
            <th>Kuantitas</th>
            <th>Total</th>
            <th>Tgl Transaksi</th>
            <th>Karyawan</th>
          </tr>

          <?php foreach ($rows as $row) : ?>
          <tr>
            <td><?=$row['kode_transaksi']?></td>
            <td><?=$row['produk_terjual_multivalue']?></td>
            <td><?=$row['total_kuantitas']?></td>
            <td>
              Rp.
              <?=$row['total_pembelian']?>
            </td>
            <td><?=$row['tanggal_terjual']?></td>
            <td><?=$row['karyawan_melayani']?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </section>
    <!-- Kolom Manajemen Transaksi End -->

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
