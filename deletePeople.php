<?php
require("database/dbPeople.php");
$id = $_GET["id"];


if (delete($id) > 0) {
    echo '<script>
alert("berhasil dihapus")
document.location.href = "peoplePage.php"
</script>';
} else {
    echo '<script>
alert("gagal dihapus")
document.location.href = "peoplePage.php"
</script>';
}