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




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1024;">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Home</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="./userPage/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .bg-dark-ph {
        background-color: #1b1b1b;
    }

    .bg-dark-light-ph {
        background-color: #292929;
        color: #ffffff;
    }

    .bg-dark-gray-ph {
        background-color: #808080;
    }

    .bg-dark-yellow-ph {
        color: #1b1b1b;
        background-color: #ffa31a;
    }

    .border-dark {
        border-color: #1b1b1b;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark-ph">
        <a class="navbar-brand font-weight-bold" href="homeAdmin.php">Admin<span class="bg-dark-yellow-ph">DB</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Movie</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="moviePage.php">Movie Page</a>
                        <a class="dropdown-item" href="addMovie.php">Add Movie</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">People</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="peoplePage.php">People Page</a>
                        <a class="dropdown-item" href="addPeople.php">Add People</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Character</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="characterPage.php">Character Page</a>
                        <a class="dropdown-item" href="addCharacter.php">Add Character</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Company</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="productionCompanyPage.php">Company Page</a>
                        <a class="dropdown-item" href="addProductionCompany.php">Add Company</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">

                <a class="btn btn-secondary my-2 my-sm-0 bg-dark-yellow-ph font-weight-bold"
                    href="userPage/logout.php">Logout</a>
            </form>
        </div>
    </nav>

    <main role="main" class="container-fluid bg-dark-light-ph">
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
                    <input type="date" name="release-date" id="release-date" required
                        value="<?= $movie['release_date'] ?>">
                </li>
                <li>
                    <label for="duration">Duration</label>
                    <input type="number" name="duration" id="duration" required value="<?= $movie['duration'] ?>">
                    Minute
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
                        <option value="<?= $rating ?>"
                            <?= ($rating == $movie['rating']) ? 'selected="selected"' : '' ?>>
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
                    <div class="genre-list"
                        style="width: 400px; height: 200px; overflow: scroll; border: 1px solid black;">
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
    </main><!-- /.container -->
    <!-- Footer -->
    <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script>
    window.jQuery || document.write('<script src="./userPage/bootstrap/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="./userPage/bootstrap/js/bootstrap.bundle.min.js"></script>

</html>