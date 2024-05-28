<?php
require '../PHP/crud-produk.php';

$kode = $_GET['kode'];

$rows = query("SELECT * FROM produk WHERE kode='$kode'")[0];
// var_dump($rows);

if ( isset($_POST['submit']) ){
  if (ubah($_POST) > 0){
    echo "
    <script>
        alert('data berhasil diubah');
        document.location.href = 'produk.php';
        exit;
    </script>
    ";
  } else {
    echo "
    <script>
        alert('data gagal diubah');
        document.location.href = 'produk.php';
        exit;
    </script>
    ";
  }
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>Edit Produk</title>

    <!-- Alertify -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <!-- CSS Alertify -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css"/>
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="../CSS/style-ft-produk.css"
    />

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
        <span class="icon utama"><i data-feather="shopping-cart"></i></span>
        <a
          href="produk.php"
          class="menu-nav"
          >Produk</a
        >
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
      <h1 style="margin-right: 90px">PRODUK</h1>
      <a
        href="akun.php"
        id="profile"
        ><i data-feather="user"></i
      ></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

    <!-- Form Tambah Karyawan Start -->
    <div class="form-container">
      <div class="form">
        <div class="icon">
          <div class="keterangan">
            <span id="feather-icon"><i data-feather="table"></i></span>
            <span>EDIT PRODUCT</span>
          </div>
        </div>
        <form id="myForm" action="" method="POST" enctype="multipart/form-data" >
          <input type="hidden" id="gambarLama" name="gambarLama"  value="<?= $rows['gambar'] ?>">
          <label for="kode">Kode Buah</label><br />
          <input
            type="text"
            id="kode"
            name="kode"
            placeholder="P00X"
            value="<?= $rows['kode'] ?>"
            required
          /><br />

          <label for="nama_produk">Produk</label><br />
          <input
            type="text"
            id="nama_produk"
            name="nama_produk"
            placeholder="Product Name"
            value="<?= $rows['nama_produk'] ?>"
            required
          /><br />

          <label for="harga">Harga Beli</label><br />
          <input
            type="number"
            id="harga_beli"
            name="harga_beli"
            placeholder="Rp. xxxxx"
            value="<?= $rows['harga_grosir'] ?>"
            required
          /><br />

          <label for="harga">Harga Jual</label><br />
          <input
            type="number"
            id="harga_jual"
            name="harga_jual"
            placeholder="Rp. xxxxx"
            value="<?= $rows['harga'] ?>"
            required
          /><br />


          <label for="berat">Berat</label><br />
          <input
            type="text"
            id="berat"
            name="berat"
            placeholder="123kg"
            value="<?= $rows['berat'] ?>"
            required
          /><br />

          <label for="tanggal">Tanggal Kadaluarsa</label><br />
          <input
            type="date"
            id="tanggal"
            name="tanggal"
            value="<?= $rows['tanggal_kadaluarsa'] ?>"
            required
          /><br />

          <label for="stok">Stok</label><br />
          <input
            type="number"
            id="stok"
            name="stok"
            step="2"
            placeholder="Stock"
            value="<?= $rows['stok'] ?>"
            required
          /><br />

          <label for="gambar_produk">Gambar</label><br />
          <img src="../IMG/<?= $rows['gambar'] ?>" alt="" style ="width: 90px; margin-bottom: 20px;"><br>
          <input
            type="file"
            id="gambar_produk"
            name="gambar_produk"
          /><br />

          <button
          type="submit"
          name = "submit"
          style="cursor: pointer"
          onclick="confirmEdit()"
        >
          Submit
        </button>


        <button
          type="reset"
          style="cursor: pointer"
          id="reset"
          name="reset"
        >
          Reset
        </button>
        </form>
      </div>
    </div>

    <!-- Form Tambah Karyawan End -->
    <script>
      feather.replace();
    </script>
    <!-- <script src="/JAVASCRIPT/produk.js"></script> -->
  </body>
</html>
