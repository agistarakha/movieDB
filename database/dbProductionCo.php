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
    $description = secureInput($data["description"]);


    //upload logo
    $logo = upload();
    if (!$logo) {
        return false;
    }

    // Insert to db
    $query = "INSERT INTO production_company
        VALUES
        ('','$name','$logo','$description')
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Update data
function upload()
{
    // Initialization
    $fileName = $_FILES['logo']['name'];
    $fileSize = $_FILES['logo']['size'];
    $error = $_FILES['logo']['error'];
    $tmpName = $_FILES['logo']['tmp_name'];

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

    move_uploaded_file($tmpName, 'img/productionCo/' . $newFileName);

    return $newFileName;
}

// Delete data
function delete($id)
{
    global $conn;
    $production_company = query("SELECT * FROM production_company WHERE production_co_id = $id")[0];
    //Delete image file
    unlink('img/productionCo/' . $production_company["logo"]);

    mysqli_query($conn, "DELETE FROM production_company WHERE production_co_id = $id");
    return mysqli_affected_rows($conn);
}

// Update data
function update($data)
{
    // Initialize data
    global $conn;
    $id = secureInput($data["id"]);
    $name = secureInput($data["name"]);
    $description = secureInput($data["description"]);

    $oldLogo = $data["old-logo"];
    //If logo not changed or changed
    if ($_FILES['logo']['error'] == 4) {
        $logo = $oldLogo;
    } else {
        unlink('img/productionCo/' . $oldLogo);
        $logo = upload();
    }

    $query = "UPDATE production_company SET
                    name = '$name',
                    description = '$description',
                    logo = '$logo'
                    WHERE production_co_id = '$id';
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Search data
function search($keyword)
{
    $query = "SELECT * FROM production_company WHERE name LIKE '%$keyword%'";
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