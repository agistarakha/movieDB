<?php
// Initialize db connection
$conn = mysqli_connect("localhost", "root", "", "moviedb");

// Data query
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

// Create new data
function add($data, $id)
{
    // Data initialization
    // date_default_timezone_set('Asia/Jakarta');
    global $conn;
    $title = secureInput($data["title"]);
    $releaseDate = secureInput($data["release-date"]);
    $duration = secureInput($data["duration"]);
    $plot = secureInput($data["plot"]);
    $language = secureInput($data["language"]);
    $directorId = secureInput($data["director-id"]);
    $trailer = secureInput($data["trailer"]);
    $productionCoId = secureInput($data["production-co-id"]);
    $rating = secureInput($data["rating"]);
    // $date = date('Y-m-d H:i:s');
    // echo $date;
    // die;


    //upload poster
    $poster = upload();
    if (!$poster) {
        return false;
    }


    // Insert to db
    $query = "INSERT INTO movie
        VALUES
        ('$id','$productionCoId','$directorId','$title','$trailer','$poster','$releaseDate','$language','$rating','$plot','$duration','')
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function addGenre($data, $id)
{
    global $conn;
    $movieId = $data['movie-id'];
    mysqli_query($conn, "DELETE FROM genre WHERE movie_id = $movieId");
    $genres = $data['genre'];
    if (isset($genres)) {
        if (is_array($genres)) {
            foreach ($genres as $value) {
                mysqli_query($conn, "INSERT INTO genre VALUES('$value','$id')");
            }
        } else {
            $value = $genres;
            mysqli_query($conn, "INSERT INTO genre VALUES('$value','$id')");
        }
    }
    return isset($genres);
}
// Update data
function upload()
{
    // Initialization
    $fileName = $_FILES['poster']['name'];
    $fileSize = $_FILES['poster']['size'];
    $error = $_FILES['poster']['error'];
    $tmpName = $_FILES['poster']['tmp_name'];

    //Check if image not upladed
    if ($error == 4) {
        echo "<script> alert('Upload image required') </script>";
        return false;
    }

    // File extension check
    $validImageExtension = ['jpg', 'png', 'jpeg'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo "<script> alert('Only accept jpg, png, jpeg extension') </script>";
    }

    //Size limit check
    if ($fileSize > 1000000) {
        echo "<script> alert('file cannot be uploaded, file size is more than 1mb') </script>";
    }

    $newFileName = uniqid();
    $newFileName .= "." . $imageExtension;

    move_uploaded_file($tmpName, 'img/movie/' . $newFileName);

    return $newFileName;
}

// Delete data
function delete($id)
{
    global $conn;
    $movie = query("SELECT * FROM movie WHERE movie_id = '$id'")[0];
    //Delete image file
    unlink('img/movie/' . $movie["poster"]);
    mysqli_query($conn, "DELETE FROM movie_character WHERE movie_id='$id'");
    mysqli_query($conn, "DELETE FROM review WHERE movie_id='$id'");
    mysqli_query($conn, "DELETE FROM genre WHERE movie_id = '$id'");
    mysqli_query($conn, "DELETE FROM movie WHERE movie_id = '$id'");
    return mysqli_affected_rows($conn);
}

// Update data
function update($data, $id)
{
    // Initialize data
    global $conn;
    $title = secureInput($data["title"]);
    $releaseDate = secureInput($data["release-date"]);
    $duration = secureInput($data["duration"]);
    $plot = secureInput($data["plot"]);
    $language = secureInput($data["language"]);
    $directorId = secureInput($data["director-id"]);
    $trailer = secureInput($data["trailer"]);
    $productionCoId = secureInput($data["production-co-id"]);
    $rating = secureInput($data["rating"]);
    $oldPoster = $data["old-poster"];

    //If poster not changed or changed
    if ($_FILES['poster']['error'] == 4) {
        $poster = $oldPoster;
    } else {
        unlink('img/movie/' . $oldPoster);
        $poster = upload();
    }

    $query = "UPDATE movie SET
                    title = '$title',
                    rating = '$rating',
                    release_date = '$releaseDate',
                    plot = '$plot',
                    poster = '$poster',
                    director_id = '$directorId',
                    production_co_id = '$productionCoId',
                    language = '$language',
                    trailer = '$trailer',
                    duration = '$duration'
                    WHERE movie_id = '$id';
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Search data
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