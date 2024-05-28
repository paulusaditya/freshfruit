<?php
require '../PHP/crud-produk.php';
include "../PHP/apriori.php";
// require '../PHP/apriori.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>Dashboard</title>

    <!-- Alertify -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

    <!-- CSS Alertify -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css"/>

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="../CSS/style-data-proses.css"
    />
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- Navigasi -->
    <nav class="navbar">
      <h1>INVENTORY SYSTEM</h1>
      <div class="container-dashboard">
        <span class="icon"><i data-feather="home"></i></span>
        <a
          href="index.php"
          class="menu-nav dashboard"
          >Dashboard</a
        >
      </div>
      <div class="container-produk">
        <span class="icon"><i data-feather="shopping-cart"></i></span>
        <a
          href="produk.php"
          class="menu-nav"
          >Produk</a
        >
      </div>
      <div class="container-karyawan">
        <span class="icon"><i data-feather="users"></i></span>
        <a
          href="karyawan.php"
          class="menu-nav"
          >Karyawan</a
        >
      </div>
      <div class="container-transaksi">
        <span class="icon"><i data-feather="dollar-sign"></i></span>
        <a
          href="transaksi.php"
          class="menu-nav"
          >Transaksi</a
        >
      </div>
      <div class="container-report">
          <span class="icon"><i data-feather="file-text"></i></span>
          <a
            href="report.php"
            class="menu-nav"
            >Report</a
          >
      </div>
      <div class="container-promosi">
        <span class="icon utama"><i data-feather="table"></i></span>
        <a
          href="#"
          class="menu-nav"
          >Data Proses</a
        >
      </div>
      <div class="container-akun">
        <span class="icon"><i data-feather="user"></i></span>
        <a
          href="akun.php"
          class="menu-nav"
          >Akun</a
        >
      </div>
    </nav>
    <!-- Navigasi End -->

    <!-- Profile -->
    <header class="profile">
      <h2>FreshFruit</h2>
      <h1 style="margin-right: 90px">APRIORI</h1>
      <a
        href="akun.php"
        id="profile"
        ><i data-feather="user"></i
      ></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

       <!-- Input Periode -->
       <section class="container-detail-transaksi">
        <div class="icon">
          <div class="keterangan">
            <span id="feather-icon"><i data-feather="table"></i></span>
            <span>FREQUENT ITEMSET</span>
          </div>
          <div class="info-data-proses" id="infoDataProses">
            ?
          </div>

          <script>
              document.getElementById('infoDataProses').addEventListener('click', function() {
                  alertify.alert('Informasi', 
                  `<strong>Pengertian</strong><br>
                  Algoritma Apriori digunakan untuk menemukan frequent itemsets dan asosiasi rules dalam suatu dataset transaksi. Hasil dari algoritma ini biasanya disajikan dalam bentuk tabel yang membantu dalam analisis data. Berikut adalah penjelasan tentang cara membaca tabel yang dihasilkan dari algoritma Apriori:<br><br>
                  <strong>Tabel Frequent Itemsets</strong><br>
                  Tabel ini berisi itemsets yang muncul lebih sering daripada threshold support (minimum support) yang ditentukan. Tabel ini biasanya terdiri dari dua kolom utama:<br><br>

                  <b>Itemset</b>: Kombinasi item yang muncul bersama dalam transaksi.<br>
                  <b>Support</b>: Proporsi transaksi yang mengandung itemset tersebut dibandingkan dengan total transaksi.<br>
                  <b>Support Antecedent</b>: Seberapa sering item yang <i>jika dibeli</i> muncul dalam seluruh transaksi.<br>
                  <b>Confident</b>: Digunakan untuk mengevaluasi keandalan aturan asosiasi yang dihasilkan.<br>
                  <b>Candidate Itemset</b>: Itemset yang lolos seleksi min support dan min frequency.<br>
                  <b>Large Itemset</b>: Pasangan itemset (asosiasi) antara antecedent (itemset yang dibeli) dengan consequent (prediksi barang lain yang dibeli).<br><br>
                  <strong>Manfaat Penerapan Algoritma Apriori</strong><br>
                  1. Market Basket Analysis<br>
                  2. Rekomendasi Produk<br>
                  3. Manajemen Persediaan<br>
                  4. Deteksi Pola Penipuan<br>
                  5. Peletakan barang<br>
                  6. etc`);
              });
          </script>
        </div>

        <div class="c_periode">
          <h4>Choose Period</h4>
          <form
            action=""
            method="post"
            class="range-period"
          >
            <input
              type="date"
              id="range-start"
              name="range-start"
              placeholder="Start Date"
            />
            <label>&gt;</label>
            <input
              type="date"
              id="range-end"
              name="range-end"
              placeholder="End Date"
            />
            <button
              type="submit"
              class="report-button"
              name="filter"
              id="btnFilter"
            >
              Generate Report
            </button>
          </form>
        </div>
      </section>
      
    <!--  Data Proses Start -->
    <?php if ( isset($_POST["filter"]) ) : ?>
        <?php if ($dataset != null) :?>
          <div class="kolom-data-not-null">
              <span>Frequent itemset dari tanggal <b><?= $_POST["range-start"] ?></b> sampai dengan <b><?= $_POST["range-end"] ?></b></span>
            </div>
          <div class="container-data-proses">
            <!--  Keterangan Awal Data Proses -->
            <h3>Keterangan</h3>
            <span>Min Support <?= $min_support * 100?>%</span>
            <span>Min Frequency <?= $min_frequency ?></span>
            
            <!-- Tabel Pertama -->
            <div class="table-container">
              <div class="icon">
                      <div class="keterangan">
                          <span id="feather-icon"><i data-feather="table"></i></span>
                          <span>Candidate Itemset 1</span>
                      </div>
              </div>
              <table class="tabel">
                  <tr>
                      <th>Item Set</th>
                      <th>Frekuensi</th>
                      <th>Support</th>
                      <th>Keterangan</th>
                  </tr>
                      <?php foreach ($item_frequency as $item => $value): ?>
                      <tr>
                          <td><?= $item ?></td>
                          <td><?= $value ?></td>
                          <td><?= number_format(($value / $jumlah_transaksi) * 100, 2) ?>%</td>
                          <?php if (isset($eliminasi_item[$item])): ?>
                              <td><?= $eliminasi_item[$item] ?></td>
                          <?php else: ?>
                              <td>-</td>
                          <?php endif; ?>
                      </tr>
                  <?php endforeach;?>
                  </table>


                <table class="tabel">
                <div class="icon">
                    <div class="keterangan">
                        <span id="feather-icon"><i data-feather="table"></i></span>
                        <span>Large Itemset 1</span>
                    </div>
                    </div>
                    <tr>
                        <th>Item Set</th>
                        <th>Frekuensi</th>
                        <th>Support</th>
                    </tr>
                        <?php foreach($sorted_items as $items  => $value): ?>
                            <tr>
                            <td><?=$items?></td>
                            <td><?=$value?></td>
                            <td><?= number_format(($value / $jumlah_transaksi) * 100, 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                </table>

              <?php 
              $itemset_1 = [];
              foreach ($dataset as $transaction) {
                  foreach ($transaction as $item) {
                      if (!in_array([$item], $itemset_1)) {
                          $itemset_1[] = [$item];
                      }
                  }
              }

              $k = 2;
              $candidate_itemsets = generate_candidate_itemsets($itemset_1, $k);
              // var_dump($candidate_itemsets);
              $frequent_itemsets_list_a = [];

              while ($candidate_itemsets):
                  $frequent_itemsets = [];
                  $frequent_itemsets_list = [];
                  $antecedent = [];

                  $frequency = count_frequency($dataset_el, $candidate_itemsets);
                  $frequent_itemsets_list_a = array_merge($frequent_itemsets_list_a, check_frequency($frequency, $min_support, $min_frequency, $dataset_el)[0]);
                  $frequent_itemsets = array_merge($frequent_itemsets, check_frequency($frequency, $min_support, $min_frequency, $dataset_el)[0]);

                  // Buat ngecek lolos enggaknya
                  $result = check_frequency($frequency, $min_support, $min_frequency, $dataset_el);
                  $eliminasi_item = $result[1];

                  foreach ($frequent_itemsets as $items => $value){
                      $frequent_itemsets_list[] = array_unique(explode(", ", $items));
                  }

                  foreach ($frequent_itemsets_list as $itemset){
                      $antecedent[] = array_slice($itemset, 0, -1);
                  }

                  $result = [];

                  foreach ($antecedent as $key){
                      $antecedent_key = implode(", ", $key);
                      if (count($key) < 2){
                          if (isset($item_frequency[$antecedent_key])){
                              $result[$antecedent_key] = $item_frequency[$antecedent_key];
                          }
                      } else {
                          if (isset($frequent_itemsets_list_a[$antecedent_key])){
                              $result[$antecedent_key] = $frequent_itemsets_list_a[$antecedent_key];
                          }
                      }
                  }
                  // var_dump($result);
                  // var_dump($antecedent);
                  // var_dump($frequent_itemsets_list_a);
                  // var_dump($frequent_itemsets);
                  ?>

                <table class="tabel">
                <div class="icon">
                <div class="keterangan">
                    <span id="feather-icon"><i data-feather="table"></i></span>
                    <span>Candidate Itemset <?= $k ?></span>
                </div>
                </div>
                    <tr>
                    <th>Item Set</th>
                    <th>Frekuensi</th>
                    <th>Support</th>
                    <th>Keterangan</th>
                    </tr>
                    <?php foreach($frequency as $items => $value): ?>
                        <tr>
                            <td><?= $items ?></td>
                            <td><?= $value ?></td>
                            <td><?= number_format(($value / $jumlah_transaksi) * 100, 2) ?>%</td>
                            <?php if (isset($eliminasi_item[$items])): ?>
                                <td><?= $eliminasi_item[$items] ?></td>
                            <?php else: ?>
                                <td>-</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>


                <table class="tabel">
                    <div class="icon">
                <div class="keterangan">
                    <span id="feather-icon"><i data-feather="table"></i></span>
                    <span>Large Itemset <?= $k ?></span>
                </div>
                </div>
                    <tr>
                        <th>Aturan</th>
                        <th>Support Itemset</th>
                        <th>Support Antecedent</th>
                        <th>Confidence</th>
                    </tr>
                    <?php foreach ($frequent_itemsets as $itemset => $values): ?>
                        <?php 
                        // $antecedents = [];
                        // $value_prev = [];
                        // foreach ($result as $items_prev => $val_prev){
                        //     if (strpos($itemset, $items_prev) !== false){
                        //         $antecedents[] = $items_prev;
                        //         $value_prev[] = $val_prev;
                        //         // break;
                        //     }
                        // }

                        // var_dump($antecedents);

                        ?>
                        <tr>
                            <td>Jika dibeli <?= substr_replace($itemset, " maka dibeli ", strrpos($itemset, ","), 1); ?></td>
                            <td><?= number_format(($values / $jumlah_transaksi) * 100, 2); ?>%</td>

                            <?php foreach ($result as $items_prev => $val_prev): ?>
                                <?php if (strpos($itemset, $items_prev) !== false): ?>
                                    <td><?= number_format(($val_prev / $jumlah_transaksi) * 100, 2); ?>%</td>
                                    <td><?= number_format(($values / $val_prev) * 100, 2); ?>%</td>
                                    <?php break;?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                        </tr>
                    <?php endforeach; ?>


                </table>
                <?php 

                    // $frequent_itemsets = array();


                    $k++;
                    $candidate_itemsets = generate_candidate_itemsets($frequent_itemsets_list, $k);

                    endwhile;
            ?>
        
          </div>
          <?php else : ?>
            <div class="kolom-data-null">
              <span><h4>Belum ada transaksi pada rentang tanggal yang ditentukan</h4></span>
            </div>
        <?php endif ?>
      <?php endif; ?>

    <script>
      feather.replace();
    </script>
    <script src="../JAVASCRIPT/promosi.js"></script>
  </body>
</html>
