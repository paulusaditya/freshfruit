<?php
require 'database.php';

$bukaTransaksi = "INSERT INTO transaksi (kode, tanggal, karyawan) VALUES ('', NOW(), 'K001')";
$result = mysqli_query($conn, $bukaTransaksi);

if ($result) {
    $response = [
        'status' => 200,
        'message' => 'Transaksi berhasil dibuka.'
    ];
} else {
    $response = [
        'status' => 500,
        'message' => 'Gagal membuka transaksi.'
    ];
}

echo json_encode($response);
?>
