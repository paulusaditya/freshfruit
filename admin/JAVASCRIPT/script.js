const tabel_produk = document.querySelector('.container-kolom-keterangan .kolom .tb_produk');
const tabel_karyawan = document.querySelector('.container-kolom-keterangan .kolom .tb_karyawan');
const tabel_m_karyawan = document.querySelector('.container-manajemen-karyawan .kolom .tb_karyawan');

for (let i = 1; i <= 5; i++) {
  const table_row_produk = document.createElement('tr');

  for (let j = 1; j <= 5; j++) {
    const isi_tabel = document.createElement('td');
    let value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
    isi_tabel.appendChild(value);
    table_row_produk.appendChild(isi_tabel);
  }

  tabel_produk.appendChild(table_row_produk);
}

for (let i = 1; i <= 10; i++) {
  const table_row_karyawan = document.createElement('tr');

  for (let j = 1; j <= 5; j++) {
    const isi_tabel = document.createElement('td');
    let value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
    isi_tabel.appendChild(value);
    table_row_karyawan.appendChild(isi_tabel);
  }

  tabel_karyawan.appendChild(table_row_karyawan);
}

for (let i = 1; i <= 10; i++) {
  const table_row_m_karyawan = document.createElement('tr');

  for (let j = 1; j <= 6; j++) {
    const isi_tabel = document.createElement('td');
    let value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
    isi_tabel.appendChild(value);
    table_row_m_karyawan.appendChild(isi_tabel);
  }

  tabel_m_karyawan.appendChild(table_row_m_karyawan);
}
