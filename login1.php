<?php
require 'connection.php';
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

// Ensure proper escaping of input data to prevent SQL injection
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// Fetch the user along with their role
$query_sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

$result = mysqli_query($conn, $query_sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // Set session
    $_SESSION["login"] = true;
    $_SESSION["usertype"] = $user["usertype"];

    // Check remember me
    if(isset($_POST['remember'])){
        // Set cookie
        setcookie('key', hash('sha256', $password), time()+60);
    }

    // Redirect based on role
    if($user["usertype"] == "admin") {
        header("Location: admin/WEB/index.php");
        
    } else if($user["usertype"] == "karyawan") {
        header("Location: karyawan/web/index.php");
    } else {
        echo "<script> 
            alert('Role tidak dikenali, Silahkan coba lagi.');
            document.location.href = 'login.php';
        </script>";
    }
    exit;
} else {
    echo "<script> 
        alert('Email atau password anda salah, Silahkan coba lagi.');
        document.location.href = 'login.php';
    </script>";
}
?>
