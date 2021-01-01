<?php
//mengecek apakah tombol sudah di klik

require("../../model/dbPeople.php");
if (isset($_POST["submit"])) {
    if (add($_POST) > 0) {
        echo '<script>
            alert("data berhasil ditambahkan")
            document.location.href = "../../views/admin/peoplePage.php"
            </script>';
    } else {
        echo '<script>
            alert("data gagal ditambahkan")
            document.location.href = "../../views/admin/peoplePage.php"
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
            <li>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </li>
            <li>
                <label for="birthday">Birthday</label>
                <input type="date" name="birthday" id="birthday" required>
            </li>
            <li>
                <label for="birth-place">Birth place</label>
                <input type="text" name="birth-place" id="birth-place" required>
            </li>
            <li>
                Description : <br>
                <textarea name="description" id="description" cols="30" rows="10" required></textarea>
            </li>
            <li>
                Role :
                <br>
                <label for="is-actor">Actor</label>
                <input type="checkbox" name="is-actor" id="is-actor">
                <br>
                <label for="is-director">Director</label>
                <input type="checkbox" name="is-director" id="is-director">

            </li>
            <li>
                <label for="photo">Photo</label>(Max size : 1mb)
                <br>(Only accept jpg, jpeg, png extension) <br>
                <input type="file" name="photo" id="photo" required>
            </li>
            <button type="submit" name="submit">Add</button>
        </form>
    </ul>
</body>

</html>