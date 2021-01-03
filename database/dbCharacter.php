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
function add($data)
{
    // Data initialization
    global $conn;
    $name = secureInput($data["name"]);
    $movieId = secureInput($data["movie-id"]);
    $actorId = secureInput($data["actor-id"]);
    $description = secureInput($data["description"]);

    //upload photo
    $photo = upload();
    if (!$photo) {
        return false;
    }

    // Insert to db
    $query = "INSERT INTO movie_character
        VALUES
        ('','$movieId','$actorId','$name','$photo','$description')
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Update data
function upload()
{
    // Initialization
    $fileName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $error = $_FILES['photo']['error'];
    $tmpName = $_FILES['photo']['tmp_name'];

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

    move_uploaded_file($tmpName, 'img/character/' . $newFileName);

    return $newFileName;
}

// Delete data
function delete($id)
{
    global $conn;
    $character = query("SELECT * FROM movie_character WHERE character_id = $id")[0];
    //Delete image file
    unlink('img/character/' . $character["photo"]);

    mysqli_query($conn, "DELETE FROM movie_character WHERE character_id = $id");
    return mysqli_affected_rows($conn);
}

// Update data
function update($data, $id)
{
    // Initialize data
    global $conn;
    $name = secureInput($data["name"]);
    $movieId = secureInput($data["movie-id"]);
    $actorId = secureInput($data["actor-id"]);
    $description = secureInput($data["description"]);

    $oldPhoto = $data["old-photo"];
    //If photo not changed or changed
    if ($_FILES['photo']['error'] == 4) {
        $photo = $oldPhoto;
    } else {
        unlink('img/character/' . $oldPhoto);
        $photo = upload();
        // die;
    }

    $query = "UPDATE movie_character SET
                    name = '$name',
                    people_id = '$actorId',
                    movie_id = '$movieId',
                    description = '$description',
                    photo = '$photo'
                    WHERE character_id = '$id';
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Search data
function search($keyword)
{
    $query = "SELECT * FROM movie_character WHERE name LIKE '%$keyword%'";
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