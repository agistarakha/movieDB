<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: userPage/login.php");
    exit;
}
//mengecek apakah tombol sudah di klik

require("database/dbCharacter.php");

$id = $_GET["id"];

$actors = query("SELECT * FROM people WHERE is_actor='1'");
$movies = query("SELECT * FROM movie");
$character = query("SELECT * FROM movie_character WHERE character_id = $id")[0];

if (isset($_POST["submit"])) {
    if (update($_POST, $id) > 0) {
        echo '<script>
            alert("data berhasil ditambahkan")
            document.location.href = "characterPage.php"
            </script>';
    } else {
        echo mysqli_error($conn);
        die;
        echo '<script>
            alert("data gagal ditambahkan")
            document.location.href = "characterPage.php"
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
    <h1>Add Character Data</h1>
    <ul>
        <form action="" method="post" enctype="multipart/form-data">
            <li>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required value="<?= $character['name'] ?>">
            </li>
            <li>
                Description : <br>
                <textarea name="description" id="description" cols="60" rows="20"
                    required><?= $character['description'] ?></textarea>
            </li>
            <li>
                <label for="actor-id">actor</label>
                <select name="actor-id" id="actor-id" required>
                    <?php foreach ($actors as $actor) : ?>
                    <option value="<?= $actor['people_id'] ?>"
                        <?= ($actor['people_id'] == $character['people_id']) ? 'selected="selected"' : '' ?>>
                        <?= $actor["name"] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="movie-id">Movie</label>
                <select name="movie-id" id="movie-id" required>
                    <?php foreach ($movies as $movie) : ?>
                    <option value="<?= $movie['movie_id'] ?>"
                        <?= ($movie['movie_id'] == $character['movie_id']) ? 'selected="selected"' : '' ?>>
                        <?= $movie["title"] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="photo">P
                    hoto</label>(Max size : 1mb)
                <br>(Only accept jpg, jpeg, png extension) <br>
                <input type="hidden" name="old-photo" value="<?= $character['photo'] ?>">
                <input type="file" name="photo" id="photo">
            </li>
            <button type="submit" name="submit">Add</button>
        </form>
    </ul>
</body>

</html>