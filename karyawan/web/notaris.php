<?php
require '../server/read.php';

$karyawan = query("SELECT karyawan.id, karyawan.nama, karyawan.email, alamat.kode AS kode_alamat, CONCAT(alamat.alamat, ', ', alamat.kota, ', ', alamat.provinsi) AS alamat, posisi_karyawan.posisi
                FROM karyawan 
                JOIN alamat ON karyawan.alamat = alamat.kode
                JOIN posisi_karyawan ON karyawan.posisi = posisi_karyawan.kode
                WHERE karyawan.id='K003';
                ");

// var_dump($karyawan);
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
      href="../css/style-notaris.css"
    />
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- Navigasi -->
    <nav class="navbar">
      <h3>INVENTORY SYSTEM</h3>
      <div class="container-akun">
        <span class="icon utama"><i data-feather="user"></i></span>
        <a
          href="#"
          class="menu-nav"
          >Akun</a
        >
      </div>
      <div class="container-produk">
        <span class="icon"><i data-feather="shopping-cart"></i></span>
        <a
          href="index.php"
          class="menu-nav"
          >Buat Transaksi</a
        >
      </div>
      <div class="container-karyawan">
        <span class="icon"><i data-feather="file-text"></i></span>
        <a
          href="data-transaksi.php"
          class="menu-nav"
          >Data Transaksi</a
        >
      </div>
    </nav>
    <!-- Navigasi End -->

    <!-- Profile -->
    <header class="profile">
      <h3>FreshFruit</h3>
      <h2 style="margin-right: 90px">PROFILE</h2>
      <a
        href="#"
        id="profile"
        ><i data-feather="user"></i
      ></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

    
    <!-- Form Data Akun Start -->
    <div class="container-data">
      <div class="container-form" style="margin-top: 30px">
      <?php foreach  ($karyawan as $row) : ?>
        <div class="icon">
          <h4>Karyawan FreshFruit</h4>
        </div>
        <table>
            <tr>
              <td>Nama </td>
              <td>: <?= $row['nama'] ?></td>
            </tr>
            <tr>
              <td>Email </td>
              <td>: <?= $row['email'] ?></td>
            </tr>
            <tr>
              <td>Posisi </td>
              <td>: <?= $row['posisi'] ?></td>
            </tr>
          

        </table>
      </div>

            <!-- <button type="button"><a href="edit-akun.php?id=<?= $row['id'] ?>&kode_alamat=<?= $row['kode_alamat'] ?>" style='color: white; text-decoration: none;'>Edit Akun</a></button> -->
            <a href="logout.php" id="logout"><button type="button">Logout</button> </a>
            <?php endforeach; ?>
    </div>
    <!-- Form Data Akun End -->

    <script>
      feather.replace();
    </script>
    <script src="../JAVASCRIPT/script.js"></script>
  </body>
</html>
