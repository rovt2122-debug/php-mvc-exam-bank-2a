// konfirmasi hapus data pakai sweetalert
document.querySelectorAll('.btn-hapus').forEach(function (btn) {
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    Swal.fire({
      icon: 'warning',
      title: 'Yakin hapus data ini?',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d64545'
    }).then(function (result) {
      if (result.isConfirmed) {
        window.location.href = btn.href;
      }
    });
  });
});
