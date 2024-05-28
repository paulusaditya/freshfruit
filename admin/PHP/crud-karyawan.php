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

    $id = $post['id'];
    $nama = $post['nama'];
    $email = $post['email'];
    $password = $post['password'];
    $password_c = $post['password-confirm'];
    $alamat = $post['alamat'];
    $kota = $post['kota'];
    $provinsi = $post['provinsi'];
    $posisi_karyawan = $post['posisi_karyawan'];

    // Memasukkan data ke tabel alamat
    $queryAlamat = "INSERT INTO alamat (kode, alamat, kota, provinsi)
                    VALUES ('', '$alamat', '$kota', '$provinsi')";
    mysqli_query($conn, $queryAlamat);

    // Mendapatkan nilai kode dari alamat yang baru saja dimasukkan
    $lastKodeQuery = "SELECT kode FROM alamat ORDER BY kode DESC LIMIT 1";
    $resultKode = mysqli_query($conn, $lastKodeQuery);
    $lastKodeRow = mysqli_fetch_assoc($resultKode);
    $lastKode = $lastKodeRow['kode'];

    // Memasukkan data ke tabel karyawan dengan nilai alamat yang baru saja didapatkan
    $queryKaryawan = "INSERT INTO karyawan (id, nama, email, password, alamat, posisi, manager)
                      VALUES ('$id', '$nama', '$email', '$password_c', '$lastKode', '$posisi_karyawan', 'ADM1')";
    mysqli_query($conn, $queryKaryawan);

    return mysqli_affected_rows($conn);
}


function hapus($id, $kode_alamat){
    global $conn;
    mysqli_query($conn, "DELETE FROM karyawan WHERE id = '$id'");
    mysqli_query($conn, "DELETE FROM alamat WHERE kode = '$kode_alamat'");

    return mysqli_affected_rows($conn);
}


function ubah($post, $kode_alamat){
    global $conn;

    $id = $post['id'];
    $nama = $post['nama'];
    $email = $post['email'];
    $password = $post['password'];
    $password_c = $post['password-confirm'];
    $alamat = $post['alamat'];
    $kota = $post['kota'];
    $provinsi = $post['provinsi'];
    $posisi_karyawan = $post['posisi_karyawan'];


    $queryAlamat = "UPDATE alamat SET
                    alamat='$alamat',
                    kota='$kota',
                    provinsi='$provinsi'
                    WHERE kode=$kode_alamat";
    $resultKode = mysqli_query($conn, $queryAlamat);
    

    $query = "UPDATE karyawan SET
                id='$id',
                nama='$nama',
                email='$email',
                password='$password_c',
                posisi='$posisi_karyawan'
                WHERE id= '$id'
                ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function cari($keyword){
    global $conn;
    $query = "SELECT karyawan.id, karyawan.nama, karyawan.email, alamat.kode AS kode_alamat, CONCAT(alamat.alamat, ', ', alamat.kota, ', ', alamat.provinsi) AS alamat, posisi_karyawan.posisi, admin.nama AS manager
    FROM karyawan
    JOIN alamat ON karyawan.alamat = alamat.kode
    JOIN posisi_karyawan ON karyawan.posisi = posisi_karyawan.kode
    JOIN admin ON karyawan.manager = admin.id
    WHERE
    karyawan.id LIKE '%$keyword%' OR
    karyawan.nama LIKE '%$keyword%' OR  
    karyawan.email LIKE '%$keyword%' OR
    alamat.alamat LIKE '%$keyword%' OR
    alamat.kota LIKE '%$keyword%' OR
    alamat.provinsi LIKE '%$keyword%' OR
    posisi_karyawan.posisi LIKE '%$keyword%';
    
        ";

    return query($query);
}

?>