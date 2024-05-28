<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />

    <title>Transaksi Kasir</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <!-- <link rel="stylesheet" href="style.css" /> -->

    <!-- CSS Alertify -->
    <link
      rel="stylesheet"
      href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"
    />
    <!-- Default theme -->
    <link
      rel="stylesheet"
      href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"
    />
    <!-- Semantic UI theme -->
    <link
      rel="stylesheet"
      href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css"
    />
    <!-- Bootstrap theme -->
    <link
      rel="stylesheet"
      href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css"
    />

    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="../CSS/style-buat-transaksi.css"
    />
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>
    <!-- Navigasi -->
    <nav class="navbar">
      <h3>INVENTORY SYSTEM</h3>
      <div class="container-akun">
        <span class="icon"><i data-feather="user"></i></span>
        <a
          href="notaris.php"
          class="menu-nav"
          >Akun</a
        >
      </div>
      <div class="container-buat-transaksi">
        <span class="icon utama"><i data-feather="shopping-cart"></i></span>
        <a
          href="#"
          class="menu-nav"
          >Buat Transaksi</a
        >
      </div>
      <div class="container-data-transaksi">
        <span class="icon"><i data-feather="file-text"></i></span>
        <a
          href="data-transaksi.php"
          class="menu-nav"
          >Data Transaksi</a
        >
      </div>
    </nav>
    <!-- Navigasi End -->

    <!-- Profile -->
    <header class="profile">
      <h2>FreshFruit</h2>
      <h1 style="margin-right: 90px">KASIR</h1>
      <a
        href="notaris.php"
        id="profile"
        ><i data-feather="user"></i
      ></a>
    </header>
    <div id="batas"></div>
    <!-- Profile end -->

    <!-- Kolom Manajemen kasir Start -->
    <section class="container-manajemen-kasir">
      <div class="icon">
        <div class="keterangan">
          <span id="feather-icon"><i data-feather="table"></i></span>
          <span>KASIR</span>
        </div>
      </div>

      <div class="kolom">
        <div class="kolom-kasir">
          <!-- Proses Kasir -->
          <div id="form-produk">
            Nama Produk:
            <input
              type="text"
              id="nama_produk"
            /><br /><br />
            <div id="detail_produk"></div>

            Jumlah Pembelian:
            <input
              type="number"
              id="jumlah_stok"
            /><br /><br />

            <div id="total_harga"></div>

            <button
              type="button"
              id="btnSimpan"
              name="btnSimpan"
            >
              Simpan
            </button>

            <button
              type="button"
              id="btnProses"
            >
              Open Transaction
            </button>
            <br /><br />

            Pembayaran:
            <input
              type="number"
              id="pembayaran"
            /><br /><br />

            Kembalian:
            <input
              type="number"
              id="kembalian"
              disabled
            /><br /><br />

            <button
              type="button"
              id="btnDone"
              onclick="confirmPurchase()"
            >
              Selesai
            </button>
          </div>

          <div class="container-nota">
            <!-- Nota Tersimpan -->
            <div class="nota-transaksi"></div>

            <div id="total_harga_nota"></div>
          </div>
        </div>
      </div>
    </section>
    <!-- Kolom Manajemen kasir End -->

    <script>
      feather.replace();
    </script>

    <script>
      $(document).ready(function () {
        $('#nama_produk').on('input', function () {
          var nama_produk = $(this).val();
          $.ajax({
            url: '../server/proses_nota.php',
            method: 'POST',
            data: { nama_produk: nama_produk },
            success: function (data) {
              $('#detail_produk').html(data);
              var harga_per_produk = $('#harga_per_produk').val();
              $('#total_harga').html('Total Harga: 0');
            },
          });
        });

        $('#jumlah_stok').on('input', function () {
          var jumlah_stok = $(this).val();
          var harga_per_produk = $('#harga_per_produk').val();
          var total_harga = harga_per_produk * jumlah_stok;
          $('#total_harga').html('Total Harga Produk: ' + total_harga);
        });

        let transaksiDibuka = false;

        $('#btnProses').click(function () {
          $.ajax({
            type: 'GET',
            url: '../server/proses_transaksi.php',
            success: function (response) {
              var res = JSON.parse(response);
              if (res.status == 200) {
                transaksiDibuka = true; // Set flag menjadi true
                alertify.success('Open Transaction', 'Transaksi berhasil dibuka: ' + res.message);
              } else {
                alertify.error('Open Transaction', 'Gagal membuka transaksi: ' + res.message);
              }
            },
            error: function (xhr, status, error) {
              console.error('Terjadi kesalahan: ' + error);
              alertify.alert('Error', 'Terjadi kesalahan saat membuka transaksi.');
            },
          });
        });

        // Tambah produk
        $('#btnSimpan').click(function () {
          if (!transaksiDibuka) {
          alertify.alert('Alert!', 'Transaksi belum dibuka!');
          return;
            }

          let kode_produk = $('#kode_produk').text();
          var kuantitas = parseInt($('#jumlah_stok').val()); // Konversi ke angka
          var harga_per_produk = parseFloat($('#harga_per_produk').val()); // Konversi ke angka
          var total_harga_produk = harga_per_produk * kuantitas;
          let nama_produk = $('#nama_produk').val();
          let kode_transaksi;

          $.ajax({
            type: 'POST',
            url: '../server/crud.php',
            data: {
              btnSimpan: true,
              kode_produk: kode_produk,
              kuantitas: kuantitas,
              total_harga_produk: total_harga_produk,
            },
            success: function (response) {
              let res = JSON.parse(response);
              kode_transaksi = res.kode_transaksi; // Tindakan setelah berhasil

              var nota_item = `
                  <div class="nota-item" id="${kode_transaksi}">
                    <div action="../server/crud.php" id="form-nota" method="get">

                      <label for="nama_produk">Nama Produk</label>
                      <input type="text" id="nama_produk_dibeli" name="nama_produk" value="${nama_produk}" disabled>

                        <br><label for="harga">Harga</label>
                        <input type="text" id="harga" name="harga" value="${$('#harga_per_produk').val()}" disabled>
                          
                        <br><label for="kuantitas">Kuantitas</label>
                        <input type="number" id="kuantitas" name="kuantitas" value="${kuantitas}" disabled>
                          
                        <br><label for="total_harga">Total Harga</label>
                        <input type="number" id="total_harga_produk" name="total_harga_produk" value="${total_harga_produk}" disabled> <br><br>
                    </div>
                    <button class="hapus" data-id="${kode_transaksi}" data-kode_produk="${kode_produk}" data-kuantitas="${kuantitas}" >x</button>
                  </div>`;

              $('.nota-transaksi').append(nota_item);

              var total_harga_nota = 0;
              $('.nota-transaksi #total_harga_produk').each(function () {
                total_harga_nota += parseInt($(this).val());
              });
              $('#total_harga_nota').html('Total Harga: ' + total_harga_nota);

              $('#jumlah_stok').val('');
            },
          });
        });

        // Hapus Transaksi
        $(document).on('click', '.hapus', function () {
          if (!transaksiDibuka) {
            alert('Transaksi belum dibuka!');
            return;
          }

          let kode_produk = $(this).data('kode_produk');
          let kuantitas = parseInt($(this).data('kuantitas'));
          let kode_transaksi = $(this).data('id');

          if (confirm('Apakah Anda yakin mau menghapus?')) {
            $.ajax({
              type: 'GET',
              url: '../server/crud.php',
              data: {
                hapus: true,
                id: kode_transaksi,
                kode_produk: kode_produk,
                kuantitas: kuantitas,
              },
              success: function (response) {
                var res = JSON.parse(response);
                if (res.status == 500) {
                  alert(res.message);
                } else {
                  alertify.set('notifier', 'position', 'top-right');
                  alertify.success('Success message');
                  // Menghapus item dari tampilan setelah berhasil dihapus dari server
                  $('#' + kode_transaksi).remove();

                  // Update total harga nota setelah item dihapus
                  var total_harga_nota = 0;
                  $('.nota-transaksi #total_harga_produk').each(function () {
                    total_harga_nota += parseInt($(this).text());
                  });
                  $('#total_harga_nota').html('Total Harga: ' + total_harga_nota);
                }
              },
            });
          }
        });

        // $('#hapus').click(function(){
        //         let kode_transaksi = $(this).closest('.nota-item').attr('id');
        //         console.log(kode_transaksi);

        //         $.ajax({
        //             type: "POST",
        //             url: "crud.php",
        //             data: { 'hapus': true, 'id': kode_transaksi },
        //             success: function (response) {
        //                     var res = JSON.parse(response);
        //                     if(res.status == 500) {
        //                         alert(res.message);
        //                     } else {
        //                         alertify.set('notifier','position', 'top-right');
        //                         alertify.success(res.message);
        //                     }
        //                 }
        //             });
        //         });

        $('#pembayaran').on('input', function () {
          var pembayaran = $('#pembayaran').val();
          var total_harga = $('#total_harga_nota').text().split(': ')[1];
          var kembalian = pembayaran - total_harga;
          $('#kembalian').val(kembalian);
        });
      });

      function confirmPurchase() {
        alertify.confirm('Harap konfirmasi ulang pembelian! Klik yakin untuk lanjut menyimpan', function (e) {
          if (e) {
            // Jika user mengklik "OK" atau "Yakin"
            alertify.success('Data berhasil disimpan');
            setTimeout(function () {
              location.reload(); // Refresh halaman
            }, 1000); // Delay 1 detik sebelum refresh halaman
          } else {
            // Jika user mengklik "Cancel" atau "Batal"
            alertify.error('Pembelian dibatalkan');
          }
        });
      }
    </script>

    <!-- <script src="../JAVASCRIPT/kasir.js"></script> -->
  </body>
</html>
