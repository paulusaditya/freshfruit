<?php

$conn = mysqli_connect("localhost", "root", "", "freshfruit");

function cari_transaksi($keyword){
    global $conn;

    $query = "SELECT  
                transaksi.kode AS kode_transaksi, 
                GROUP_CONCAT(produk.nama_produk SEPARATOR ', ') AS produk_terjual_multivalue, 
                SUM(detail_transaksi.kuantitas) AS total_kuantitas, 
                SUM(detail_transaksi.total) AS total_pembelian, 
                transaksi.tanggal AS tanggal_terjual, 
                karyawan.nama AS karyawan_melayani 
            FROM 
                transaksi 
            JOIN detail_transaksi ON detail_transaksi.kode_transaksi = transaksi.kode
            JOIN karyawan ON transaksi.karyawan = karyawan.id
            JOIN produk ON detail_transaksi.produk_terjual = produk.kode
            WHERE 
                transaksi.kode LIKE '%$keyword%' OR
                produk.nama_produk LIKE '%$keyword%' OR
                transaksi.tanggal LIKE '%$keyword%' OR
                karyawan.nama LIKE '%$keyword%'
            GROUP BY 
                transaksi.kode, 
                transaksi.tanggal, 
                karyawan.nama;
            
            ";

    return query($query);
}

?>