<?php
require '../PHP/crud-produk.php';
$rows = query("SELECT * FROM produk");
// var_dump($rows);

if ( isset($_POST["cari"]) ){
  $rows = cari_produk($_POST['keyword']);
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
    <title>Produk</title>

    <link
      rel="stylesheet"
      href="style.css"
    />
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

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

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="../CSS/style-produk.css"
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
          href="#"
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
          >Prediksi</a
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

    <!-- Fitur Search and Sort Start -->
    <!-- Fitur Search Start -->
    <div class="fitur-tambahan">
      <div class="pencarian">
      <form action="" method="post">
        <input
          type="text"
          name="keyword"
          placeholder="Search Product"
          autocomplete="off"
          required
        />
        <button type="submit" name="cari">Search</button>
        <div class="refresh"><a href="produk.php"><i data-feather="refresh-ccw"></i></a></div>
      </form>
      </div>

      <!-- Fitur Sorting Start -->
      <!-- <div class="sorting">
        <form action="">
          <label for="sort">SORT</label>
          <select
            name="sort"
            id="sort"
          >
            <option value="nama">Nama</option>
            <option value="harga">Harga</option>
            <option value="stok">Stok</option>
          </select>
        </form>
      </div> -->
    </div>
    <!-- Fitur Search nd Sort End -->

    <!-- Kolom Manajemen produk Start -->
    <section class="container-manajemen-produk">
      <div class="icon">
        <div class="keterangan">
          <span id="feather-icon"><i data-feather="table"></i></span>
          <span>PRODUK</span>
        </div>
        <div class="tambah-data"><a href="form-tambah-produk.php">ADD NEW</a></div>
      </div>
      <div class="kolom"">
        <table class="tb_produk"  style="margin: 0px; width:100%; " >
          <tr>
            <th>kode</th>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Berat</th>
            <th>Tanggal<br>Kadaluarsa</th>
            <th>Stok</th>
            <th>Actions</th>
          </tr>
            <?php foreach ($rows as $row) :?>
              <tr>
                <td><?= $row['kode'] ?></td>
                <td><img src="../IMG/<?= $row['gambar'] ?>" alt="<?= $row['gambar'] ?>" style="width: 100px"></td>
                <td><?= $row['nama_produk']?></td>
                <td><?= $row['harga']?></td>
                <td><?= $row['berat']?></td>
                <td><?= $row['tanggal_kadaluarsa']?></td>
                <td><?= $row['stok']?></td>
                <td>
                  <div class="btn_edit"><a href="form-edit-produk.php?kode=<?= $row['kode']?>">E</a></div>
                  <div class="btn_hapus">
                      <a href="../PHP/hapus.php?kode=<?= htmlspecialchars($row['kode'], ENT_QUOTES, 'UTF-8') ?>" onclick="return confirmDeletion(this)">x</a>
                  </div>
                </td>
              </tr>
                <?php endforeach; ?>
        </table>
      </div>
    </section>

    <script>
        function confirmDeletion(element) {
            alertify.confirm('Konfirmasi Penghapusan', 'Apa Anda yakin mau menghapus?', 
                function() { // Jika user klik "OK"
                    window.location.href = element.href;
                },
                function() { // Jika user klik "Cancel"
                    // Tidak melakukan apapun
                }
            );
            return false; // Mencegah default action dari link
        }
        </script>
        
    <!-- Kolom Manajemen produk End -->
    <script>
      feather.replace();
    </script>
    <!-- <script src="/JAVASCRIPT/produk.js"></script> -->
  </body>
</html>
