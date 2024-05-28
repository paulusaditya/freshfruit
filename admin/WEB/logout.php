<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('key', '', time() -3600);

echo "<script>
confirm('Anda Yakin Keluar?');
document.location.href = '../../index.php';
</script>";
exit;

?>