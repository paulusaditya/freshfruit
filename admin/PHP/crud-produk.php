<!-- Live data -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        


<?php

$conn = mysqli_connect("localhost", "root", "", "freshfruit");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


function tambah($post){
    global $conn;

    $kode = htmlspecialchars($post['kode']);
    $nama_produk = htmlspecialchars($post['nama_produk']);
    $harga_jual = htmlspecialchars($post['harga_jual']);
    $harga_beli = htmlspecialchars($post['harga_beli']);
    $berat = htmlspecialchars($post['berat']);
    $tanggal = htmlspecialchars($post['tanggal']);
    $stok = htmlspecialchars($post['stok']);

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO produk (kode, gambar, nama_produk, harga, harga_grosir, berat, tanggal_kadaluarsa, stok)
              VALUES ('$kode', '$gambar','$nama_produk', '$harga_jual', '$harga_beli', '$berat', '$tanggal', '$stok')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus($kode){
    global $conn;
    mysqli_query($conn, "DELETE FROM produk WHERE kode = '$kode'");

    return mysqli_affected_rows($conn);
}

function ubah($post){
    global $conn;

    $kode = htmlspecialchars($post['kode']);
    $nama_produk = htmlspecialchars($post['nama_produk']);
    $harga_jual = htmlspecialchars($post['harga_jual']);
    $harga_beli = htmlspecialchars($post['harga_beli']);
    $berat = htmlspecialchars($post['berat']);
    $tanggal = htmlspecialchars($post['tanggal']);
    $stok = htmlspecialchars($post['stok']);
    $gambarLama = htmlspecialchars($post['gambarLama']);


    if ($_FILES['gambar_produk']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE produk SET
                kode='$kode',
                gambar='$gambar',
                nama_produk='$nama_produk',
                harga='$harga_jual',
                harga_grosir='$harga_beli',
                berat='$berat',
                tanggal_kadaluarsa='$tanggal',
                stok='$stok'
                WHERE kode= '$kode'
                ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari_produk($keyword){
    global $conn;

    $query = "SELECT * FROM produk WHERE 
    kode LIKE '%$keyword%' OR
    nama_produk LIKE '%$keyword%' OR
    harga LIKE '%$keyword%' OR
    berat LIKE '%$keyword%' OR
    tanggal_kadaluarsa LIKE '%$keyword%';";


    return query($query);
}

function upload(){
    $namaFile = $_FILES['gambar_produk']['name'];
    $tmpFile = $_FILES['gambar_produk']['tmp_name'];
    $error = $_FILES['gambar_produk']['error'];

    $ekstensi = ["jpg", "jpeg", "png"];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    $namaBaru = uniqid();
    $namaBaru .= ".";
    $namaBaru .= $ekstensiGambar;

    if ( $error === 4 ) {
        echo '<script>
        alert("Gambar tidak boleh kosong.");
        </script>';
        return false;
    }

    if ( !in_array($ekstensiGambar, $ekstensi) ) {
        echo '<script>
        alert("Ekstensi file tidak diperbolehkan. Harap unggah file dengan ekstensi yang benar.");
        </script>';
        return false;
    }

    move_uploaded_file($tmpFile, '../IMG/' . $namaBaru);

    return $namaBaru;
}





?>