<?php
require '../PHP/crud-produk.php';
$rows = query("SELECT karyawan.id, karyawan.nama, karyawan.email, posisi_karyawan.posisi FROM karyawan JOIN posisi_karyawan ON (karyawan.posisi = posisi_karyawan.kode)");

$produk = query("SELECT 
                    p.nama_produk AS nama_produk,
                    p.harga AS harga_produk,
                    p.stok AS stok_produk,
                    p.tanggal_kadaluarsa AS tanggal_kadaluarsa
                FROM 
                    (
                        SELECT 
                            dt.produk_terjual,
                            SUM(dt.kuantitas) AS total_kuantitas
                        FROM 
                            detail_transaksi dt
                        GROUP BY 
                            dt.produk_terjual
                        ORDER BY 
                            total_kuantitas DESC
                        LIMIT 5 -- Ambil 5 produk dengan kuantitas penjualan terbanyak
                    ) AS top_products
                JOIN 
                    produk p ON top_products.produk_terjual = p.kode
                ORDER BY 
                    top_products.total_kuantitas DESC;
                ");

$penjualan_bulan_ini = query("SELECT
                                SUM(dt.total) AS total_penjualan
                            FROM
                                detail_transaksi dt
                            JOIN
                                transaksi t ON dt.kode_transaksi = t.kode
                            WHERE
                                YEAR(t.tanggal) = YEAR(CURDATE()) AND
                                MONTH(t.tanggal) = MONTH(CURDATE()) AND
                                t.tanggal <= CURDATE();
                      ");

$jumlah_produk = query("SELECT COUNT(*) AS jumlah_produk_tersedia FROM produk; ");

$jumlah_karyawan = query("SELECT COUNT(*) AS jumlah_karyawan FROM karyawan; ");


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
      href="../CSS/style-dashboard.css"
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
        <span class="icon utama"><i data-feather="home"></i></span>
        <a href="#" class="menu-nav dashboard">Dashboard</a>
      </div>
      <div class="container-produk">
        <span class="icon"><i data-feather="shopping-cart"></i></span>
        <a href="produk.php" class="menu-nav">Produk</a>
      </div>
      <div class="container-karyawan">
        <span class="icon"><i data-feather="users"></i></span>
        <a href="karyawan.php" class="menu-nav">Karyawan</a>
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
          <span class="icon"><i data-feather="file-text"></i></span>
          <a
            href="report.php"
            class="menu-nav"
            >Report</a
          >
      </div>
      <div class="container-promosi">
        <span class="icon"><i data-feather="table"></i></span>
        <a href="data_proses.php" class="menu-nav">Data Proses</a>
      </div>
      <div class="container-akun">
        <span class="icon"><i data-feather="user"></i></span>
        <a href="akun.php" class="menu-nav">Akun</a>
      </div>
    </nav>
    <!-- Navigasi End -->

    <!-- Profile -->
    <header class="profile">
      <h2>FreshFruit</h2>
      <h1 style="margin-right: 90px;">DASHBOARD</h1>
      <a href="akun.php" id="profile"><i data-feather="user"></i></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

    <!-- Content Card -->
    <section class="container-card">
        <div class="cards">
          <div class="simbol card-1">
            <span><i data-feather="user"></i></span>
          </div>
          <div class="keterangan">
          <?php foreach ($jumlah_produk as $jumlah) : ?>          
            <h4><?= $jumlah["jumlah_produk_tersedia"]; ?></h4>
            <?php endforeach; ?>
            <a href="produk.php">Produk</a>
          </div>
        </div>
        <div class="cards">
          <div class="simbol card-2">
            <span><i data-feather="dollar-sign"></i></span>
          </div>
          <div class="keterangan">
            <?php foreach ($penjualan_bulan_ini as $income) : ?>          
            <h4>Rp. <?= $income["total_penjualan"]; ?></h4>
            <?php endforeach; ?>
            <a href="transaksi.php">Income (Bulan ini)</a>
          </div>
        </div>
        <div class="cards">
          <div class="simbol card-3">
            <span><i data-feather="users"></i></span>
          </div>
          <div class="keterangan">
            <?php foreach ($jumlah_karyawan as $jumlah) : ?>          
              <h4><?= $jumlah["jumlah_karyawan"]; ?></h4>
            <?php endforeach; ?>
            <a href="karyawan.php">Karyawan</a>
          </div>
        </div>
      </section>
    </div>
    <!-- Content Card End -->


    <!-- Kolom Keterangan Lanjutan -->
    <section class="container-kolom-keterangan">
      <div class="pisah">
        <div class="icon">
            <span><i data-feather="table"></i></span>
            <h4>PRODUK TERLARIS</h4>
          </div>
        <div class="kolom produk">
          <table class="tb_produk">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Tgl Kdlwrs</th>
            </tr>
            <?php $no = 1; ?>
            <?php foreach ( $produk as $row ): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $row['nama_produk']; ?></td>
                  <td><?= $row['harga_produk']; ?></td>
                  <td><?= $row['stok_produk']; ?></td>
                  <td><?= $row['tanggal_kadaluarsa']; ?></td>
                </tr>
                <?php endforeach;?>
          </table>
      </div>

      </div>
      <div class="pisah">
        <div class="icon">
          <span><i data-feather="table"></i></span>
          <h4>KARYAWAN</h4>
        </div>
      <div class="kolom karyawan">
        <table class="tb_karyawan">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Posisi</th>
          </tr>


            <?php foreach ( $rows as $row ): ?>
              <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['nama']; ?></td>
              <td><?= $row['email']; ?></td>
              <td><?= $row['posisi']; ?></td>
              </tr>
              <?php endforeach;?>
        </table>
      </div>
    </div>
    </section>
    <!-- Kolom Keterangan Lanjutan End -->

    <script>
      feather.replace();
    </script>
    <!-- <script src="/JAVASCRIPT/script.js"></script> -->
  </body>
</html>
