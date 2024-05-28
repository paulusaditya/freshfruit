<?php
$conn = mysqli_connect("localhost", "root", "", "freshfruit");

$dari_tgl = "";
$sampai_tgl = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dari_tgl = mysqli_real_escape_string($conn, $_POST["range-start"]);
    $sampai_tgl = mysqli_real_escape_string($conn, $_POST["range-end"]);
}

function filter() {
    global $conn, $dari_tgl, $sampai_tgl;

    $data_transaksi = mysqli_query($conn, 
        "SELECT
        produk.nama_produk,
        produk.harga,
        produk.harga_grosir,
        SUM(detail_transaksi.kuantitas) AS total_kuantitas,
        SUM(detail_transaksi.total) AS total_penjualan,
        (produk.harga - produk.harga_grosir) * SUM(detail_transaksi.kuantitas) AS total_profit,
        (SELECT 
            SUM(detail_transaksi.total) 
            FROM 
                detail_transaksi 
            JOIN   
                transaksi ON detail_transaksi.kode_transaksi = transaksi.kode 
            WHERE 
                transaksi.tanggal BETWEEN '$dari_tgl' AND '$sampai_tgl') AS grand_total_penjualan
    FROM
        detail_transaksi
    JOIN transaksi ON detail_transaksi.kode_transaksi = transaksi.kode
    JOIN produk ON detail_transaksi.produk_terjual = produk.kode
    WHERE
        transaksi.tanggal BETWEEN '$dari_tgl' AND '$sampai_tgl'
    GROUP BY
        produk.kode,
        produk.nama_produk,
        produk.harga,
        produk.harga_grosir;"
    );    

    $row = [];
    while ($reports = mysqli_fetch_assoc($data_transaksi)){
        $row[] = $reports;
    }


    return $row;
}

?>