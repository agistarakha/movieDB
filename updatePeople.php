<?php
//mengecek apakah tombol sudah di klik

require("database/dbPeople.php");
$id = $_GET["id"];

$people = query("SELECT * FROM people WHERE people_id = $id")[0];


if (isset($_POST["submit"])) {
    //cek keberhasilan data
    if (update($_POST) > 0) {
        echo '<script>
            alert("berhasil diubah")
            document.location.href = "peoplePage.php"
            </script>';
    } else {
        echo '<script>
            alert("Gagal diubah")
            </script>';
        echo mysqli_error($conn);
    }
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
            <input type="hidden" name="id" value="<?= $people["people_id"] ?>> 
            <li>
                <label for=" name">Name</label>
            <input type="text" name="name" id="name" required value="<?= $people["name"] ?>">
            </li>
            <li>
                <label for=" birthday">Birthday</label>
                <input type="date" name="birthday" id="birthday" value="<?= $people["birthday"] ?>" required>
            </li>
            <li>
                <label for=" birth-place">Birth place</label>
                <input type="text" name="birth-place" id="birth-place" value="<?= $people["birth_place"] ?>" required>
            </li>
            <li>
                Description : <br>
                <textarea name="description" id="description" cols="30" rows="10"
                    required><?= $people["description"] ?></textarea>
            </li>
            <li>
                Role :
                <br>
                <label for="is-actor">Actor</label>
                <input type="checkbox" name="is-actor" id="is-actor" value="<?= $people["is_actor"] ?>" <?php if ($people['is_actor'] == 1) {
                                                                                                            echo "checked='checked'";
                                                                                                        } ?>>
                <br>
                <label for=" is-director">Director</label>
                <input type="checkbox" name="is-director" id="is-director" value="<?= $people["is_director"] ?>"
                    <?php if ($people['is_director'] == 1) {
                                                                                                                        echo "checked='checked'";
                                                                                                                    } ?>>

            </li>
            <li>
                <label for=" photo">Photo</label>(Max size : 1mb)
                <br>(Only accept jpg, jpeg, png extension) <br>
                <input type="hidden" name="old-photo" value="<?= $people["photo"] ?>">
                <img src="img/people/<?= $people["photo"] ?>" alt="">
                <input type="file" name="photo" id="photo">
            </li>
            <button type="submit" name="submit">Add</button>
            <a href="peoplePage.php">cancel</a>
        </form>
    </ul>
</body>

</html>