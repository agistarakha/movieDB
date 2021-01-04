<?php
require("../database/dbProductionCo.php");
$id = $_GET["id"];

$character = query("SELECT * FROM movie_character WHERE character_id = $id")[0];
$movieId = $character['movie_id'];
$peopleId = $character['people_id'];
$people = query("SELECT * FROM people WHERE people_id=$peopleId")[0];
$movie = query("SELECT * FROM movie WHERE movie_id='$movieId'")[0];

// var_dump($movie);
// die;
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
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
        <a class="navbar-brand font-weight-bold" href="../index.php">Movie<span class="bg-dark-yellow-ph">DB</span></a>
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
                        <a class="dropdown-item" href="top.php">Top Movie</a>
                        <a class="dropdown-item" href="new.php">New Movie</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Join</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="login.php">Sign in</a>
                        <a class="dropdown-item" href="register.php">Sign up</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Search</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="searchMovie.php">Search Movie</a>
                        <a class="dropdown-item" href="searchPeople.php">Search People</a>
                        <a class="dropdown-item" href="searchCharacter.php">Search Character</a>
                        <a class="dropdown-item" href="searchCompany.php">Search Company</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Help</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="faq.html">FAQs</a>
                        <a class="dropdown-item" href="support.html">Support</a>
                        <a class="dropdown-item" href="about.html">About</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">

                <a class="btn btn-secondary my-2 my-sm-0 bg-dark-yellow-ph font-weight-bold"
                    href="logout.php">Logout</a>
            </form>
        </div>
    </nav>

    <main role="main" class="container-fluid bg-dark-light-ph">
        <div class="row border-bottom border-dark">
            <h2>
                <?= $character['name'] ?>
            </h2>
        </div>
        <div class="row">
            <div class="col-3 border-right border-dark">
                <img src="../img/character/<?= $character['photo'] ?>" class="img-fluid" alt="Responsive image">

                <h5>Information</h5>
                <p class="text-sm-left">Name :<span style="color: #808080;"> <?= $character['name'] ?></span>

                </p>

            </div>
            <div class="col-8 ml-3">
                <div class="row">
                    <h3>Description</h3>
                </div>
                <div class="row">
                    <p>
                        <?= $character['description'] ?>
                    </p>
                </div>
                <div class="row">
                    <h3>Movie</h3>
                </div>
                <div class="row">
                    <table class="table table-hover bg-dark-light-ph">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Poster</th>
                                <th scope="col">Movie</th>
                                <th scope="col">Score</th>
                                <th scope="col">Detail</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row" class="text-white"><?= 1 ?></th>
                                <td><a href="detail.php?id=<?= $movie['movie_id'] ?>"><img
                                            src="../img/movie/<?= $movie['poster'] ?>" alt=""></a></td>
                                <td><a href="detail.php?id=<?= $movie['movie_id'] ?>" class="text-white">
                                        Title : <?= $movie['title'] ?>
                                        <br>Release Date : <?= $movie['release_date'] ?>
                                    </a></td>
                                <td class="text-white"><?= $movie['score'] ?></td>
                                <td class="text-center"><a href="detail.php?id=<?= $movie['movie_id'] ?>"
                                        class="btn btn btn-secondary bg-dark-ph font-weight-bold">Detail</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <h3>Performed by</h3>
                </div>
                <div class="row">
                    <table class="table table-hover bg-dark-light-ph">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Detail</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row" class="text-white"><?= 1 ?></th>
                                <td><a href="detailPeople.php?id=<?= $people['people_id'] ?>"><img
                                            src="../img/people/<?= $people['photo'] ?>" alt=""></a></td>
                                <td><a href="detailPeople.php?id=<?= $people['people_id'] ?>" class="text-white">
                                        Name : <?= $people['name'] ?>
                                        <br>Birth Date : <?= $people['birthday'] ?>
                                    </a></td>
                                <td class="text-center"><a href="detailPeople.php?id=<?= $people['people_id'] ?>"
                                        class="btn btn btn-secondary bg-dark-ph font-weight-bold">Detail</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
    </main><!-- /.container -->
    <!-- Footer -->
    <footer class="page-footer font-small bg-dark-ph" style="color: #ffffff;">

        <!-- Footer Links -->
        <div class="container text-center text-md-left">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-md-4 mx-auto">

                    <!-- Content -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Movie<span class="bg-dark-yellow-ph">DB</span>
                    </h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab earum voluptas voluptate temporibus
                        ipsum optio dolore sequi maiores aliquam facere, quas dignissimos voluptatibus quis repellat,
                        enim maxime non eum magnam.</p>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Movie</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="top.php">Top Movie</a>
                        </li>
                        <li>
                            <a href="new.php">Recent Movie</a>
                        </li>
                        <li>
                            <a href="search.php">Search Movie</a>
                        </li>
                    </ul>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Help</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="faq.html">FAQs</a>
                        </li>
                        <li>
                            <a href="support.html">Support</a>
                        </li>
                        <li>
                            <a href="about.html">About</a>
                        </li>
                        <li>
                            <a href="agreement.html">Terms of Service</a>
                        </li>
                        <li>
                            <a href="policy.html">Privacy Policy</a>
                        </li>

                    </ul>

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        <hr>



        <hr>

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3 bg-dark-light-ph">© 2020 Copyright:
            <a href="../index.php"> MovieDB</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script>
    window.jQuery || document.write('<script src="./bootstrap/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

</html>