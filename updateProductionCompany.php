<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: userPage/login.php");
    exit;
}
//mengecek apakah tombol sudah di klik

require("database/dbProductionCo.php");
$id = $_GET["id"];

$company = query("SELECT * FROM production_company WHERE production_co_id = $id")[0];

if (isset($_POST["submit"])) {
    if (update($_POST) > 0) {
        echo '<script>
            alert("data berhasil diubah")
            document.location.href = "productionCompanyPage.php"
            </script>';
    } else {
        echo '<script>
            alert("data gagal diubah")
            document.location.href = "productionCompanyPage.php"
            </script>';
    }

    echo mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
</head>

<body>
    <h1>Tambah Data Anime</h1>
    <ul>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $company['production_co_id'] ?>">
            <li>
                <label for=" name">Name</label>
                <input type="text" name="name" id="name" required value="<?= $company['name'] ?>">
            </li>

            <li>
                Description : <br>
                <textarea name="description" id="description" cols="30" rows="10"
                    required><?= $company['description'] ?></textarea>
            </li>

            <li>
                <label for="logo">Logo</label>(Max size : 1mb)
                <input type="hidden" name="old-logo" value="<?= $company["logo"] ?>">
                <br>(Only accept jpg, jpeg, png extension) <br>
                <input type="file" name="logo" id="logo">
            </li>
            <button type="submit" name="submit">Update</button>
            <a href="productionCompanyPage.php">Cancel</a>
        </form>
    </ul>
</body>

</html>