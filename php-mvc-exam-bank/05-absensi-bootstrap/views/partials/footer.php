</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
<?php if (isset($_SESSION['flash_sukses'])): ?>
<script>
Swal.fire({ icon: 'success', title: '<?= htmlspecialchars($_SESSION['flash_sukses']) ?>', timer: 2200, showConfirmButton: false });
</script>
<?php unset($_SESSION['flash_sukses']); endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
<script>
Swal.fire({ icon: 'error', title: '<?= htmlspecialchars($_SESSION['flash_error']) ?>' });
</script>
<?php unset($_SESSION['flash_error']); endif; ?>
</body>
</html>
