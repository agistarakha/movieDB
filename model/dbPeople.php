<?php
$conn = mysqli_connect("localhost", "root", "", "moviedb");
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

function add($data)
{
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
    $query = "INSERT INTO people
        VALUES
        ('','$name','$birthday','$birthPlace','$photo','$description','$isActor','$isDirector')
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{
    $fileName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $error = $_FILES['photo']['error'];
    $tmpName = $_FILES['photo']['tmp_name'];

    //cek apakah gambar di upload
    if ($error == 4) {
        echo "<script> alert('Mohon Upload gambar') </script>";
        return false;
    }
    // cek type yang di upload

    $validImageExtension = ['jpg', 'png', 'jpeg'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo "<script> alert('Hanya dapat menerima ekstensi jpg, png, jpeg') </script>";
    }

    //jika ukurannya terlalu besar
    if ($fileSize > 1000000) {
        echo "<script> alert('Ukuran gambar tidak boleh melebihi 1mb') </script>";
    }
    //Lolos pengecekan gambar

    $newFileName = uniqid();
    $newFileName .= "." . $imageExtension;

    move_uploaded_file($tmpName, '../../img/people/' . $newFileName);

    return $newFileName;
}

function delete($id)
{
    global $conn;
    $people = query("SELECT * FROM people WHERE people_id = $id")[0];
    unlink('../../img/people/' . $people["photo"]);
    mysqli_query($conn, "DELETE FROM people WHERE people_id = $id");
    return mysqli_affected_rows($conn);
}

function update($data)
{
    global $conn;
    $id = secureInput($data["id"]);
    $name = secureInput($data["name"]);
    $birthday = secureInput($data["birthday"]);
    $birthPlace = secureInput($data["birth-place"]);
    $description = secureInput($data["description"]);
    $isActor = isset($data["is-actor"]) ? 1 : 0;
    $isDirector = isset($data["is-director"]) ? 1 : 0;

    $oldPhoto = $data["old-photo"];
    //cek apakah photo diganti
    if ($_FILES['photo']['error'] == 4) {
        $photo = $oldPhoto;
    } else {
        unlink('../../img/people/' . $oldPhoto);
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

function search($keyword)
{
    $query = "SELECT * FROM people WHERE name LIKE '%$keyword%'";
    return query($query);
}

function secureInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}