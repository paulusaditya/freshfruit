<?php

require 'crud-produk.php';

$kode = $_GET["kode"];

if (hapus( $kode ) > 0) {
    echo "
    <script>
        document.location.href = '../WEB/produk.php';
        exit;
    </script>
    ";

} else {
    echo "
    <script>
        alert('data gagal dihapus');
        document.location.href = '../WEB/produk.php';
        exit;
    </script>
    ";
}

?>