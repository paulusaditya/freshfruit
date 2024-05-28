<?php
require 'database.php';


if(isset($_POST['btnSimpan']))
{
    $kode_produk = mysqli_real_escape_string($conn, $_POST["kode_produk"]);
    $kuantitas = $_POST["kuantitas"];
    $total_harga_produk = $_POST["total_harga_produk"];

    $lastKodeQuery = "SELECT kode FROM transaksi ORDER BY kode DESC LIMIT 1";
    $resultKode = mysqli_query($conn, $lastKodeQuery);
    $lastKodeRow = mysqli_fetch_assoc($resultKode);
    $lastKode = $lastKodeRow['kode'];

    $reduceStok = "UPDATE produk SET stok = stok - $kuantitas WHERE kode='$kode_produk'";
    $resultStok = mysqli_query($conn, $reduceStok);

    $insertTransaksi = "INSERT INTO detail_transaksi (id, kode_transaksi, produk_terjual, kuantitas, total)
                    VALUES ('', '$lastKode', '$kode_produk', '$kuantitas', '$total_harga_produk')";
    $query_run = mysqli_query($conn, $insertTransaksi);

    $inserted_id = mysqli_insert_id($conn);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Product Successfully Added',
            'kode_transaksi' => $inserted_id
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Error Adding'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['hapus'])) {
    $kode_produk = mysqli_real_escape_string($conn, $_GET["kode_produk"]);
    $kuantitas = $_GET["kuantitas"];
    $kode_transaksi = mysqli_real_escape_string($conn, $_GET['id']);

    $pulihkanStok = "UPDATE produk SET stok = stok + $kuantitas WHERE kode='$kode_produk'";
    $resultStok = mysqli_query($conn, $pulihkanStok);
    
    // Hapus data dari database
    $query = "DELETE FROM detail_transaksi WHERE id='$kode_transaksi'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $response = [
            'status' => 200,
            'message' => 'Product Deleted Successfully'
        ];
    } else {
        $response = [
            'status' => 500,
            'message' => 'Product Was Not Deleted Successfully'
        ];
    }
    echo json_encode($response);
    exit;
}

// $id = $_GET["id"];


// function hapus($id){
//     global $conn;
//     mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id = '$id'");

//     return mysqli_affected_rows($conn);
// }

// if (hapus( $id ) > 0) {
//     echo "
//     <script>
//         alert('data berhasil dihapus');
//         document.location.href = 'index.php';
//         exit;
//     </script>
//     ";

// } else {
//     echo "
//     <script>
//         alert('data gagal dihapus');
//         document.location.href = 'index.php';
//         exit;
//     </script>
//     ";
// }

// if(isset($_GET['hapus']))
// {
//     $id_transaksi = mysqli_real_escape_string($conn, $_GET['id']);
//     $query = "DELETE FROM detail_transaksi WHERE id='$id_transaksi'";
//     $query_run = mysqli_query($conn, $query);

//     if($query_run)
//     {
//         $res = [
//             'status' => 200,
//             'message' => 'Product Deleted Successfully'
//         ];
//         echo json_encode($res);
//         return;
//     }
//     else
//     {
//         $res = [
//             'status' => 500,
//             'message' => 'Product Was Not Deleted Successfully'
//         ];
//         echo json_encode($res);
//         return;
//     }
// }


?>
