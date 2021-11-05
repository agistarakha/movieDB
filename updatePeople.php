<?php
//mengecek apakah tombol sudah di klik
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: userPage/login.php");
    exit;
}

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
        <h1>Tambah Data People</h1>
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
                    <input type="text" name="birth-place" id="birth-place" value="<?= $people["birth_place"] ?>"
                        required>
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