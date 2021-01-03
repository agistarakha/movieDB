<?php
require("database/dbMovie.php");


//Pagination setup
$dataForEachPage = 2;
$dataCount = count(query("SELECT * FROM movie"));
$pageCount = ceil($dataCount / $dataForEachPage);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$firstData = ($dataForEachPage * $activePage) - $dataForEachPage;

// get all data
$movies = query("SELECT * FROM movie ORDER BY release_date DESC LIMIT $firstData,$dataForEachPage");

//Search
if (isset($_POST["submit"])) {
    $movies = search($_POST["keyword"]);
    // echo mysqli_error($conn);
    // die;
    // var_dump($movies);
    // die;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>movie</title>
</head>

<body>
    <h1>movie</h1>
    <a href="addMovie.php">Add</a>
    <br><br>
    <!-- Search form -->
    <form action="" method="post">
        <label for="keyword">Search Movie</label><br>
        <input type="text" name="keyword" id="keyword" size="50" autofocus placeholder="Search movie by name"
            autocomplete="off">
        <button type="submit" name="submit">search</button>
    </form>
    <!-- Search form end -->
    <br><br>
    <!-- navigation -->
    <?php if ($activePage != 1) : ?>
    <a href="?page=<?= $activePage - 1 ?>" style="font-weight: bold;">&laquo</a>
    <?php endif ?>

    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
    <?php if ($i == $activePage) : ?>
    <a href="?page=<?= $i ?>" style="font-weight: bold;color: red;"><?= $i ?></a>
    <?php else : ?>
    <a href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endif; ?>
    <?php endfor; ?>
    <?php if ($activePage !=  $pageCount) : ?>
    <a href="?page=<?php echo $activePage + 1 ?>" style="font-weight: bold;">&raquo;</a>
    <?php endif ?>
    <!-- Navigation End -->

    <!-- Data List -->
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>poster</th>
            <th>Aksi</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
        <!-- <?php $i = 1 ?> -->
        <?php foreach ($movies as $movie) : ?>
        <tr>
            <td><?= $movie["movie_id"] ?></td>
            <td><img style="height: 25%;" src="img/movie/<?= $movie["poster"]; ?>" alt=""></td>
            <td><a href="updateMovie.php?id=<?= $movie['movie_id']; ?>">Edit</a>|<a
                    href="deleteMovie.php?id=<?= $movie['movie_id']; ?>" onclick="return confirm('yakin?')">Delete</a>
            </td>
            <td><?= $movie["title"] ?></td>
            <td><?= $movie["plot"] ?></td>
        </tr>
        <?php $i++ ?>
        <?php endforeach ?>
    </table>
    <!-- Data List End -->


    <!-- navigation -->
    <?php if ($activePage != 1) : ?>
    <a href="?page=<?= $activePage - 1 ?>" style="font-weight: bold;">&laquo</a>
    <?php endif ?>

    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
    <?php if ($i == $activePage) : ?>
    <a href="?page=<?= $i ?>" style="font-weight: bold;color: red;"><?= $i ?></a>
    <?php else : ?>
    <a href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endif; ?>
    <?php endfor; ?>
    <?php if ($activePage !=  $pageCount) : ?>
    <a href="?page=<?php echo $activePage + 1 ?>" style="font-weight: bold;">&raquo;</a>
    <?php endif ?>
    <!-- Navigation End -->
</body>

</html>