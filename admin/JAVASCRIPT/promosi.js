const active_btn = document.querySelector('.container-promosi-3 .kolom .tabel .btn-act div');
const btn = document.querySelector('.container-promosi-3 .kolom .tabel .btn-act');

btn.addEventListener('click', function (e) {
  active_btn.classList.toggle('active-btn');
  if (!active_btn.classList.contains('active-btn')) {
    btn.style.backgroundColor = 'red';
  } else {
    btn.style.backgroundColor = 'lime';
  }
});
