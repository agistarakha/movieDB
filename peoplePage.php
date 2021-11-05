<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: userPage/login.php");
    exit;
}
require("database/dbPeople.php");


//Pagination setup
$dataForEachPage = 2;
$dataCount = count(query("SELECT * FROM people"));
$pageCount = ceil($dataCount / $dataForEachPage);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$firstData = ($dataForEachPage * $activePage) - $dataForEachPage;

// get all data
$peoples = query("SELECT * FROM people ORDER BY people_id DESC LIMIT $firstData,$dataForEachPage");

//Search
if (isset($_POST["submit"])) {
    $peoples = search($_POST["keyword"]);
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
        <h1>People</h1>
        <a href="addPeople.php" class="btn btn-secondary">Add</a>
        <br><br>
        <!-- Search form -->
        <form action="" method="post">
            <label for="keyword">Search People</label><br>
            <input type="text" name="keyword" id="keyword" size="50" autofocus placeholder="Search people by name"
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
                <th>Photo</th>
                <th>Aksi</th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Birth Place</th>
            </tr>
            <!-- <?php $i = 1 ?> -->
            <?php foreach ($peoples as $people) : ?>
            <tr>
                <td><?= $people["people_id"] ?></td>
                <td><img style="height: 25%;" src="img/people/<?= $people["photo"]; ?>" alt=""></td>
                <td><a href="updatePeople.php?id=<?= $people["people_id"]; ?>">Ubah</a>|<a
                        href="deletePeople.php?id=<?= $people["people_id"]; ?>"
                        onclick="return confirm('yakin?')">Hapus</a>
                </td>
                <td><?= $people["name"] ?></td>
                <td><?= $people["birthday"] ?></td>
                <td><?= $people["birth_place"] ?></td>
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