<?php
//mengecek apakah tombol sudah di klik
session_start();

require("../database/dbMovie.php");
$id = $_GET["id"];
date_default_timezone_set('Asia/Jakarta');


$movie = query("SELECT * FROM movie WHERE movie_id='$id'")[0];
$directorId = $movie['director_id'];
$companyId = $movie['production_co_id'];
$actors = query("SELECT * FROM people WHERE is_actor='1'");
$director = query("SELECT * FROM people WHERE people_id=$directorId")[0];
$company = query("SELECT * FROM production_company WHERE production_co_id=$companyId")[0];
$date = date('Y-m-d H:i:s');
$reviews = query("SELECT * FROM review WHERE movie_id='$id' ORDER BY posted_date");

$movieGenre = query("SELECT genre_name FROM genre WHERE movie_id='$id'");
$selectedGenre = [];
foreach ($movieGenre as $genre) {
    $selectedGenre[] = $genre["genre_name"];
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
                <?= $movie['title'] ?>
            </h2>
        </div>
        <div class="row">
            <div class="col-3 border-right border-dark">
                <img src="../img/movie/<?= $movie['poster'] ?>" class="img-fluid" alt="Responsive image">

                <h5>Information</h5>
                <p class="text-sm-left">Title :<span style="color: #808080;"> <?= $movie['title'] ?></span>
                    <br>Release Date : <span style="color: #808080;"><?= $movie['release_date'] ?></span>
                    <br>Genre : <span style="color: #808080;"><?= implode(', ', $selectedGenre) ?></span>
                    <br>Director : <span style="color: #808080;"><?= $director['name'] ?></span>

                    <br>Language : <span style="color: #808080;"><?= $movie['language'] ?></span>
                    <br>Actor : <span style="color: #808080;">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Suscipit, praesentium.</span>
                    <br>Production company : <span style="color: #808080;"><?= $company['name'] ?></span>
                    <br>Rating : <span style="color: #808080;"><?= $movie['rating'] ?></span>
                    <br>Duration : <span style="color: #808080;"><?= $movie['duration'] ?> minute</span>

                </p>

            </div>
            <div class="col-8 ml-3">

                <div class="row">
                    <ul class="nav nav-pills">
                        <li class="nav-item text-black">
                            <a class="nav-link bg-dark-yellow-ph mr-1 text-dark font-weight-bold"
                                href="detail.php?id=<?= $id ?>">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white bg-dark mr-1" href="review.php?id=<?= $id ?>">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white bg-dark" href="writeReview.php?id=<?= $id ?>">✎Write
                                Review</a>
                        </li>


                    </ul>
                </div>

                <?php foreach ($reviews as $review) : ?>
                <div class="row bg-dark-ph p-3 mt-2" style="border: 1px solid #575757;">
                    <div class="row mb-1">
                        <p class="ml-3"><span class="font-weight-bolder">User id:<?= $review['user_id'] ?></span>
                            <br><span style="color: #808080;">Posted <?= $review['posted_date'] ?></span>
                            <br>Score : <span class="font-weight-bolder"
                                style="color: #22ff1a;"><?= $review['score'] ?></span>

                        </p>
                    </div>
                    <div class="row border-top">
                        <p class="text-sm-left font-weight-lighter"><span class="font-weight-bolder">Reviews :</span>
                            <br>lorem*25<?= $review['comment'] ?>
                        </p>
                    </div>
                </div>
                <?php endforeach ?>

                <div class="row mt-2 mb-3">
                    <button type="button" class="btn btn-warning m-auto">More</button>

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