<?php
$conn = mysqli_connect("localhost", "root", "", "freshfruit");

$dari_tgl = "";
$sampai_tgl = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dari_tgl = mysqli_real_escape_string($conn, $_POST["range-start"]);
    $sampai_tgl = mysqli_real_escape_string($conn, $_POST["range-end"]);
}

$rows = query("SELECT 
              dt.kode_transaksi, 
              p.nama_produk 
              FROM 
              detail_transaksi dt 
              JOIN transaksi t ON  dt.kode_transaksi=t.kode 
              JOIN produk p ON dt.produk_terjual = p.kode
              WHERE t.tanggal BETWEEN '$dari_tgl' AND '$sampai_tgl'
              ORDER BY dt.kode_transaksi
              ");

$dataset = array();
foreach ($rows as $row) {
    $dataset[$row['kode_transaksi']][] = $row['nama_produk'];
}


$dataset = array_values($dataset);

// var_dump($dataset);

$min_support = 0.3;
$min_frequency = 3;
$jumlah_transaksi = count($dataset);


function frequency_item($data) {
    $freq_dict = [];
    foreach ($data as $sublist) {
        foreach ($sublist as $item) {
            if (array_key_exists($item, $freq_dict)) {
                $freq_dict[$item] += 1;
            } else {
                $freq_dict[$item] = 1;
            }
        }
    }

    return $freq_dict;
}

$item_frequency = frequency_item($dataset);
// var_dump($item_frequency);


function eliminasi_item($frekuensi, $min_frequency, $dataset, $min_support) {
    $keys_to_remove = [];
    $eliminasi_item = [];
    $subArray;
    foreach ($frekuensi as $key => $value) {
        $p_support = $value / count($dataset);

        if ($value >= $min_frequency && $p_support >= $min_support) {
            $eliminasi_item[$key] = "lolos";
        } else {
            $keys_to_remove[] = $key;
            $eliminasi_item[$key] = "Tidak lolos";
        }
    }
    
    foreach ($keys_to_remove as $key) {
        unset($frekuensi[$key]);
    }

    foreach ($dataset as $key1 => &$subArray) {
        foreach ($subArray as $key2 => $value) {
            if (in_array($value, $keys_to_remove)) {
                unset($subArray[$key2]);
            }
        }
        $subArray = array_values($subArray);
    }

    return [$frekuensi, $eliminasi_item, $dataset];
}

$result = eliminasi_item($item_frequency, $min_frequency, $dataset, $min_support);
$sorted_items = $result[0];
$eliminasi_item = $result[1];
$dataset_el = $result[2];

// var_dump($dataset_el);


// Start Apriori
function removeDuplicateValues($array) {
    $uniqueArray = array();
    foreach ($array as $subArray) {
        // Urutkan nilai dalam sub array untuk membandingkan kesamaan isi
        sort($subArray);
        // Jika sub array belum ada di $uniqueArray, tambahkan ke $uniqueArray
        if (!in_array($subArray, $uniqueArray)) {
            $uniqueArray[] = $subArray;
        }
    }
    return $uniqueArray;
}

// Fungsi untuk menghasilkan candidate itemsets
function generate_candidate_itemsets($itemset, $k) {
    $candidate_itemsets = [];
    $n = count($itemset);
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            $new_itemset = array_unique(array_merge($itemset[$i], $itemset[$j]));
            if (count($new_itemset) == $k) {
                $candidate_itemsets[] = array_values($new_itemset); // Convert to indexed array
            }
        }
    }
    
    // Panggil fungsi removeDuplicateValues untuk menghapus nilai ganda
    $candidate_itemsets = removeDuplicateValues($candidate_itemsets);
    
    // var_dump($candidate_itemsets);
    return $candidate_itemsets;
}


function count_frequency($dataset, $candidate_itemsets) {
    $frequency = [];
    foreach ($dataset as $transaction) {
        foreach ($candidate_itemsets as $itemset) {
            if (empty(array_diff($itemset, $transaction))) {
                $itemset_str = implode(", ", $itemset);
                if (isset($frequency[$itemset_str])) {
                    $frequency[$itemset_str]++;
                } else {
                    $frequency[$itemset_str] = 1;
                }
            }
        }
    }
    return $frequency;
}


function check_frequency($frequency, $min_support, $min_frequency, $dataset) {
    $frequent_itemsets = [];
    $eliminasi_item = [];
    foreach ($frequency as $itemset => $count) {
        $support = $count / count($dataset);
        if ($support >= $min_support && $count >= $min_frequency) {
            $frequent_itemsets[$itemset] = $count;
            $eliminasi_item[$itemset] = "Lolos";
        } else {
            $eliminasi_item[$itemset] = "Tidak Lolos";
        }
    }
    return [$frequent_itemsets, $eliminasi_item];
}


?>