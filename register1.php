<?php

require 'connection.php';
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

$query_sql = "INSERT INTO users (name, email, password)
                VALUES ( '$name', '$email', '$password')";

if (mysqli_query($conn,$query_sql)) {
    echo "<script>
    alert('Akun Berhasil Dibuat');
    document.location.href = 'login.php';
    </script>";
} else {
    echo "Pendaftaran gagal:" . mysqli_error($conn);
}
