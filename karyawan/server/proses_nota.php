<?php
// Connect to the database
$host = "localhost";
$user = "root";
$password = "";
$database = "freshfruit";

$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Getthe product code from the form data
$nama_produk = $_POST['nama_produk'];

// Query the database for the product information
$sql = "SELECT * FROM produk WHERE nama_produk = '$nama_produk'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (mysqli_num_rows($result) > 0) {
    // Output the product information
    while($row = mysqli_fetch_assoc($result)) {
        echo "Kode Produk: <span id='kode_produk'>". $row["kode"] . "</span> <br>";
        echo "Nama Produk: ". $row["nama_produk"]. "<br>";
        echo "Harga: <input type='hidden' id='harga_per_produk' value='". $row["harga"]. "' class='harga_per_produk'>". $row["harga"]. "<br>";
        echo "Berat: ". $row["berat"]. "<br>";
        echo "Tanggal Kadaluarsa: ". $row["tanggal_kadaluarsa"]. "<br>";
        echo "Stok: ". $row["stok"]. "<br>";
        echo "<div class='total_harga'></div>";
    }
} else {
    echo "0 results";
}

// Close the database connection
mysqli_close($conn);
?>