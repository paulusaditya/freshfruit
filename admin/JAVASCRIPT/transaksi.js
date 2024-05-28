// const tabel_m_transaksi = document.querySelector('.container-manajemen-transaksi .kolom .tb_transaksi');
// const tabel_d_transaksi = document.querySelector('.container-detail-transaksi .kolom .tb_detail_transaksi');
// const tabel_p_permintaan = document.querySelector('.container-prediksi-permintaan .kolom .tb_prediksi_permintaan');

// for (let i = 1; i <= 10; i++) {
//   const table_row_m_transaksi = document.createElement('tr');

//   for (let j = 1; j <= 7; j++) {
//     const isi_tabel = document.createElement('td');
//     let value = null;
//     if (j !== 7) {
//       value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
//       isi_tabel.appendChild(value);
//       table_row_m_transaksi.appendChild(isi_tabel);
//     } else {
//       const btn_hapus = document.createElement('div');
//       const a_hapus = document.createElement('a');
//       a_hapus.textContent = 'x';
//       btn_hapus.classList.add('btn_hapus');
//       btn_hapus.appendChild(a_hapus);
//       isi_tabel.appendChild(btn_hapus);
//       table_row_m_transaksi.appendChild(isi_tabel);
//     }
//   }

//   tabel_m_transaksi.appendChild(table_row_m_transaksi);
// }

// for (let i = 1; i <= 5; i++) {
//   const table_row_d_transaksi = document.createElement('tr');

//   for (let j = 1; j <= 6; j++) {
//     const isi_tabel = document.createElement('td');
//     let value = null;
//     value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
//     isi_tabel.appendChild(value);
//     table_row_d_transaksi.appendChild(isi_tabel);
//   }

//   tabel_d_transaksi.appendChild(table_row_d_transaksi);
// }

// for (let i = 1; i <= 10; i++) {
//   const table_row_p_permintaan = document.createElement('tr');

//   for (let j = 1; j <= 4; j++) {
//     const isi_tabel = document.createElement('td');
//     let value = null;
//     value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
//     isi_tabel.appendChild(value);
//     table_row_p_permintaan.appendChild(isi_tabel);
//   }
//   tabel_p_permintaan.appendChild(table_row_p_permintaan);
// }

let btnFilter = document.getElementById('btnFilter');

btnFilter.addEventListener('click', function () {
  console.log('Tombol Filter diklik'); // Periksa apakah event listener berjalan

  var kolom = document.querySelector('.kolom-report');
  kolom.style.display = 'block'; // Ubah properti display menjadi block

  console.log('Properti display:', kolom.style.display); // Periksa apakah properti display diubah menjadi block
});
