<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: userPage/login.php");
    exit;
}
require("database/dbMovie.php");
$id = $_GET["id"];


if (delete($id) > 0) {
    echo '<script>
alert("berhasil dihapus")
document.location.href = "moviePage.php"
</script>';
} else {
    echo mysqli_error($conn);
    die;
    echo '<script>
alert("gagal dihapus")
document.location.href = "moviePage.php"
</script>';
}