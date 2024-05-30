<?php
require '../PHP/crud-karyawan.php';

$id = $_GET['id'];
$kode_alamat = $_GET['kode_alamat'];
$posisi_k = query("SELECT * FROM posisi_karyawan");

$rows = query("SELECT karyawan.id, karyawan.nama, karyawan.email, karyawan.password, alamat.kode, alamat.alamat AS alamat, alamat.kota AS kota, alamat.provinsi AS provinsi, posisi_karyawan.kode AS posisi
              FROM karyawan 
              JOIN alamat ON karyawan.alamat = alamat.kode
              JOIN posisi_karyawan ON karyawan.posisi = posisi_karyawan.kode
              WHERE karyawan.id = '$id'
                ")[0];
// var_dump($rows);

if ( isset($_POST['submit']) ){
  if (ubah($_POST, $kode_alamat) > 0){
    echo "
    <script>
        alert('data berhasil diubah');
        document.location.href = 'karyawan.php';
        exit;
    </script>
    ";
  } else {
    echo "
    <script>
        alert('data gagal diubah');
        document.location.href = 'karyawan.php';
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
    <title>Edit Karyawan</title>

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="../CSS/style-fe-karyawan.css"
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
      <div class="container-karyawan">
        <span class="icon utama"><i data-feather="users"></i></span>
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
      <h1 style="margin-right: 90px">MANAJEMEN KARYAWAN</h1>
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
            <span>EDIT KARYAWAN</span>
          </div>
        </div>
        <form
        action=""
          method="POST"
          onsubmit="return validatePassword()"
        >
          <label for="id">Id</label><br />
          <input
            type="text"
            id="id"
            name="id"
            placeholder="K00X"
            value="<?= $rows['id'] ?>"
            required
          /><br />

          <label for="nama">Nama Karyawan</label><br />
          <input
            type="text"
            id="nama"
            name="nama"
            placeholder="Employee Name"
            value="<?= $rows['nama'] ?>"
            required
          /><br />

          <label for="email">Email</label><br />
          <input
            type="email"
            id="email"
            name="email"
            placeholder="email@example.com"
            value="<?= $rows['email'] ?>"
            required
          /><br />

          <label for="password">Password</label><br />
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Their Password"
            value="<?= $rows['password'] ?>"
            required
          /><br />

          <label for="password-confirm">Konfirmasi Password</label><br />
          <input
            type="password"
            id="password-confirm"
            name="password-confirm"
            placeholder="Their Password"
            required
          /><br />

          <label for="alamat">Alamat</label><br />
          <input
            type="text"
            id="alamat"
            name="alamat"
            placeholder="Address"
            value="<?= $rows['alamat'] ?>"
            required
          /><br />

          <label for="kota">Kota</label><br />
          <input
            type="text"
            id="kota"
            name="kota"
            placeholder="City"
            value="<?= $rows['kota'] ?>"
            required
          /><br />

          <label for="provinsi">Provinsi</label><br />
          <input
            type="text"
            id="provinsi"
            name="provinsi"
            placeholder="Province"
            value="<?= $rows['provinsi'] ?>"
            required
          /><br />

          <label for="posisi_karyawan">Posisi Karyawan</label><br />
          <input
              type="text"
              id="posisi_karyawan"
              name="posisi_karyawan"
              list="posisi_karyawan_list"
              placeholder="Position"
              value="<?= $rows['posisi'] ?>"
              required
          />
          <datalist id="posisi_karyawan_list">
              <?php foreach ($posisi_k as $posisi) : ?>
              <option value="<?= htmlspecialchars($posisi["kode"])?>"><?= htmlspecialchars($posisi["posisi"])?></option>
              <?php endforeach; ?>
          </datalist>
          
          <br />

          <button
            type="submit"
            name="submit"
            style="cursor: pointer"
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
    <script src="/JAVASCRIPT/karyawan.js"></script>
  </body>
</html>
