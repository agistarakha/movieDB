<?php
//mengecek apakah tombol sudah di klik

require("database/dbMovie.php");
$genres = ["Absurdist/Sureal", "Action,", "Adventure", "Comedy", "Crime", "Drama", "Fantasy", "Historical", "Horror", "Magical realism", "Mystery", "Paranoid Fiction", "Philosophical", "Political", "Romance", "Saga", "Satire", "Sci-fi", "Social", "Speculative", "Thriller", "Urban", "Western"];
$ratings = ["G", "PG", "PG-13", "R", "NC-17"];

$directors = query("SELECT * FROM people WHERE is_director='1'");
$companies = query("SELECT * FROM production_company");
$id = uniqid();
echo $id;
if (isset($_POST["submit"])) {
    if (add($_POST, $id) > 0 && addGenre($_POST, $id) > 0) {
        echo '<script>
            alert("data berhasil ditambahkan")
            document.location.href = "moviePage.php"
            </script>';
    } else {
        // echo mysqli_error($conn);
        // die;
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
                <input type="text" name="title" id="title" required>
            </li>
            <li>
                <label for="release-date">Release Date</label>
                <input type="date" name="release-date" id="release-date" required>
            </li>
            <li>
                <label for="duration">Duration</label>
                <input type="number" name="duration" id="duration" required> Minute
            </li>
            <li>
                <label for="language">language</label>
                <input type="text" name="language" id="language" required>
            </li>
            <li>
                Plot : <br>
                <textarea name="plot" id="plot" cols="60" rows="20" required></textarea>
            </li>
            <li>
                <label for="rating">Rating</label>
                <select name="rating" id="rating" required>
                    <?php foreach ($ratings as $rating) : ?>
                    <option value="<?= $rating ?>"><?= $rating ?></option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="director-id">Director</label>
                <select name="director-id" id="director-id" required>
                    <?php foreach ($directors as $director) : ?>
                    <option value="<?= $director['people_id'] ?>">
                        <?= $director["name"] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="production-co-id">Production Company</label>
                <select name="production-co-id" id="production-co-id" required>
                    <?php foreach ($companies as $company) : ?>
                    <option value="<?= $company['production_co_id'] ?>">
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
                    <input type="checkbox" id="genre<?= $i ?>" name="genre[]" value="<?= $genre ?>">
                    <br>
                    <?php $i++ ?>
                    <?php endforeach ?>
                </div>
            </li>
            <li>
                <label for="trailer">Trailer URL</label>
                <input type="text" name="trailer" id="trailer" required>
            </li>
            <li>
                <label for="poster">Poster</label>(Max size : 1mb)
                <br>(Only accept jpg, jpeg, png extension) <br>
                <input type="file" name="poster" id="poster" required>
            </li>
            <button type="submit" name="submit">Add</button>
        </form>
    </ul>
</body>

</html>