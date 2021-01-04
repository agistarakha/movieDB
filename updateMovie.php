<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: userPage/login.php");
    exit;
}
//mengecek apakah tombol sudah di klik

require("database/dbMovie.php");
$id = $_GET["id"];
$genres = ["Absurdist/Sureal", "Action,", "Adventure", "Comedy", "Crime", "Drama", "Fantasy", "Historical", "Horror", "Magical realism", "Mystery", "Paranoid Fiction", "Philosophical", "Political", "Romance", "Saga", "Satire", "Sci-fi", "Social", "Speculative", "Thriller", "Urban", "Western"];

$ratings = ["G", "PG", "PG-13", "R", "NC-17"];

$movie = query("SELECT * FROM movie WHERE movie_id='$id'")[0];
$directors = query("SELECT * FROM people WHERE is_director='1'");
$companies = query("SELECT * FROM production_company");
$movieGenre = query("SELECT genre_name FROM genre WHERE movie_id='$id'");
$selectedGenre = [];
foreach ($movieGenre as $genre) {
    $selectedGenre[] = $genre["genre_name"];
}
// var_dump($selectedGenre);
// var_dump($genres);
// echo (in_array("Drama", $selectedGenre)) ? "yes" : "no";
// die;

if (isset($_POST["submit"])) {
    if (update($_POST, $id) > 0 && addGenre($_POST, $id) > 0) {
        echo '<script>
            alert("data berhasil ditambahkan")
            document.location.href = "moviePage.php"
            </script>';
    } else {
        echo mysqli_error($conn);
        die;
        echo '<script>
            alert("data gagal ditambahkan")
            document.location.href = "moviePage.php"
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
    <h1>Add Movie Data</h1>
    <ul>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="movie-id" id="movie-id" value="<?= $id ?>">
            <li>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" required value="<?= $movie['title'] ?>">
            </li>
            <li>
                <label for="release-date">Release Date</label>
                <input type="date" name="release-date" id="release-date" required value="<?= $movie['release_date'] ?>">
            </li>
            <li>
                <label for="duration">Duration</label>
                <input type="number" name="duration" id="duration" required value="<?= $movie['duration'] ?>"> Minute
            </li>
            <li>
                <label for="language">language</label>
                <input type="text" name="language" id="language" required value="<?= $movie['language'] ?>">
            </li>
            <li>
                Plot : <br>
                <textarea name="plot" id="plot" cols="60" rows="20" required><?= $movie['plot'] ?></textarea>
            </li>
            <li>
                <label for="rating">Rating</label>
                <select name="rating" id="rating" required>
                    <?php foreach ($ratings as $rating) : ?>
                    <option value="<?= $rating ?>" <?= ($rating == $movie['rating']) ? 'selected="selected"' : '' ?>>
                        <?= $rating ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="director-id">Director</label>
                <select name="director-id" id="director-id" required>
                    <?php foreach ($directors as $director) : ?>
                    <option value="<?= $director['people_id'] ?>"
                        <?= ($director['people_id'] == $movie['director_id']) ? 'selected="selected"' : '' ?>>
                        <?= $director["name"] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="production-co-id">Production Company</label>
                <select name="production-co-id" id="production-co-id" required>
                    <?php foreach ($companies as $company) : ?>
                    <option value="<?= $company['production_co_id'] ?>"
                        <?= ($company['production_co_id'] == $movie['production_co_id']) ? 'selected="selected"' : '' ?>>
                        <?= $company["name"] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                Genre : <br>
                <div class="genre-list" style="width: 400px; height: 200px; overflow: scroll; border: 1px solid black;">
                    <label for=""><strong>Choose genre:</strong> </label><br>
                    <?php $i = 0; ?>

                    <?php foreach ($genres as $genre) : ?>
                    <label for="genre<?= $i ?>"><?= $genre ?></label>
                    <input type="checkbox" id="genre<?= $i ?>" name="genre[]" value="<?= $genre ?>"
                        <?= (in_array($genre, $selectedGenre)) ? "checked='checked'" : '' ?>>
                    <br>
                    <?php $i++ ?>
                    <?php endforeach ?>
                </div>
            </li>
            <li>
                <label for="trailer">Trailer URL</label>
                <input type="text" name="trailer" id="trailer" required value="<?= $movie['trailer'] ?>">
            </li>
            <li>
                <label for="poster">Poster</label>(Max size : 1mb)
                <br>(Only accept jpg, jpeg, png extension) <br>
                <input type="hidden" name="old-poster" id="old-poster" value="<?= $movie['poster'] ?>">
                <input type="file" name="poster" id="poster">
            </li>
            <button type="submit" name="submit">Add</button>
        </form>
    </ul>
</body>

</html>