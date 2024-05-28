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

function ubah($post, $kode_alamat){
    global $conn;

    $id = $post['id'];
    $nama = $post['nama'];
    $email = $post['email'];
    $nomer = $post['nomer'];
    $password = $post['password'];
    $password_c = $post['password-confirm'];
    $alamat = $post['alamat'];
    $kota = $post['kota'];
    $provinsi = $post['provinsi'];
    $gambarLama = htmlspecialchars($post['gambarLama']);

    if ($_FILES['gambar_admin']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $queryAlamat = "UPDATE alamat SET
                    alamat='$alamat',
                    kota='$kota',
                    provinsi='$provinsi'
                    WHERE kode=$kode_alamat";
    $resultKode = mysqli_query($conn, $queryAlamat);
    

    $query = "UPDATE admin SET
                id='$id',
                nama='$nama',
                email='$email',
                nomer='$nomer',
                gambar='$gambar',
                password='$password_c'
                WHERE id= '$id'
                ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function upload(){
    $namaFile = $_FILES['gambar_admin']['name'];
    $tmpFile = $_FILES['gambar_admin']['tmp_name'];
    $error = $_FILES['gambar_admin']['error'];

    $ekstensi = ["jpg", "jpeg", "png"];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    $namaBaru = uniqid();
    $namaBaru .= ".";
    $namaBaru .= $ekstensiGambar;

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