<?php
require "crud-karyawan.php";

$id = $_GET["id"];
$kode_alamat = $_GET["kode_alamat"];

if (hapus( $id, $kode_alamat ) > 0) {
    echo "
    <script>
        document.location.href = '../WEB/karyawan.php';
        exit;
    </script>
    ";

} else {
    echo "
    <script>
        alert('data gagal dihapus');
        document.location.href = '../WEB/karyawan.php';
        exit;
    </script>
    ";
}


?>