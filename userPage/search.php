<?php
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function search($keyword)
{
    $keyword = secureInput($keyword);
    $query = "SELECT * FROM movie WHERE title LIKE '%$keyword%'";
    return query($query);
}

//Sanitize input
function secureInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//Search
if (isset($_POST["submit"])) {
    $movies = search($_POST["keyword"]);
    // echo mysqli_error($conn);
    // die;
    // var_dump($movies);
    // die;
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
    <link rel="stylesheet" href="style.css">


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
                        <a class="dropdown-item" href="search.php">Search Movie</a>
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
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button type="submit" name="keyword"
                    class="btn btn-secondary my-2 my-sm-0 bg-dark-yellow-ph font-weight-bold">Search</button>
            </form>
        </div>
    </nav>

    <main role="main" class="container-fluid bg-dark-light-ph">

        <!-- Website Header -->
        <div class="home-header">
            <h1 id="title">New Movies</h1>
            <form class="my-2 my-lg-0">
                <select name="category" id="category" class="mr-sm-2">
                    <option value="movie">Movie</option>
                    <option value="people">People</option>
                    <option value="company">Production comany</option>
                </select>
                <input class="mr-sm-2" type="text" placeholder="Search" name="keyword">
                <button type="submit" name="submit"
                    class="btn btn-secondary my-2 my-sm-0 bg-dark-yellow-ph font-weight-bold">Search</button>
            </form>
        </div>

        <!-- Website Header -->

        <!-- Movie Container -->
        <!-- Movie Container -->
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
    <!-- <script src="script.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script>
    window.jQuery || document.write('<script src="./bootstrap/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

</html>