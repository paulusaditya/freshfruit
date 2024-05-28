const tabel_m_produk = document.querySelector('.container-manajemen-produk .kolom .tb_produk');

for (let i = 1; i <= 10; i++) {
  const table_row_m_produk = document.createElement('tr');

  for (let j = 1; j <= 6; j++) {
    const isi_tabel = document.createElement('td');
    let value = null;
    if (j !== 6) {
      value = document.createTextNode(`Baris ${i}, Kolom ${j}`);
      isi_tabel.appendChild(value);
      table_row_m_produk.appendChild(isi_tabel);
    } else {
      const btn_edit = document.createElement('div');
      const btn_hapus = document.createElement('div');
      const a_edit = document.createElement('a');
      const a_hapus = document.createElement('a');
      a_edit.href = '/HTML/form-edit-produk.html';
      a_edit.textContent = 'E';
      a_hapus.textContent = 'x';
      btn_edit.classList.add('btn_edit');
      btn_hapus.classList.add('btn_hapus');
      btn_edit.appendChild(a_edit);
      btn_hapus.appendChild(a_hapus);
      isi_tabel.appendChild(btn_edit);
      isi_tabel.appendChild(btn_hapus);
      table_row_m_produk.appendChild(isi_tabel);
    }
  }

  tabel_m_produk.appendChild(table_row_m_produk);
}
