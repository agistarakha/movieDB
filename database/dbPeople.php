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
    $birthday = secureInput($data["birthday"]);
    $birthPlace = secureInput($data["birth-place"]);
    $description = secureInput($data["description"]);
    $isActor = isset($data["is-actor"]) ? 1 : 0;
    $isDirector = isset($data["is-director"]) ? 1 : 0;

    //upload photo
    $photo = upload();
    if (!$photo) {
        return false;
    }

    // Insert to db
    $query = "INSERT INTO people
        VALUES
        ('','$name','$birthday','$birthPlace','$photo','$description','$isActor','$isDirector')
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

    move_uploaded_file($tmpName, 'img/people/' . $newFileName);

    return $newFileName;
}

// Delete data
function delete($id)
{
    global $conn;
    $people = query("SELECT * FROM people WHERE people_id = $id")[0];
    //Delete image file
    unlink('../../img/people/' . $people["photo"]);

    mysqli_query($conn, "DELETE FROM people WHERE people_id = $id");
    return mysqli_affected_rows($conn);
}

// Update data
function update($data)
{
    // Initialize data
    global $conn;
    $id = secureInput($data["id"]);
    $name = secureInput($data["name"]);
    $birthday = secureInput($data["birthday"]);
    $birthPlace = secureInput($data["birth-place"]);
    $description = secureInput($data["description"]);
    $isActor = isset($data["is-actor"]) ? 1 : 0;
    $isDirector = isset($data["is-director"]) ? 1 : 0;

    $oldPhoto = $data["old-photo"];
    //If photo not changed or changed
    if ($_FILES['photo']['error'] == 4) {
        $photo = $oldPhoto;
    } else {
        unlink('img/people/' . $oldPhoto);
        $photo = upload();
    }

    $query = "UPDATE people SET
                    name = '$name',
                    birth_place = '$birthPlace',
                    birthday = '$birthday',
                    description = '$description',
                    photo = '$photo',
                    is_actor = '$isActor',
                    is_director = '$isDirector'
                    WHERE people_id = '$id';
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Search data
function search($keyword)
{
    $query = "SELECT * FROM people WHERE name LIKE '%$keyword%'";
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