<?php
require("../../model/dbPeople.php");


//Pagination setup
$dataForEachPage = 2;
$dataCount = count(query("SELECT * FROM people"));
$pageCount = ceil($dataCount / $dataForEachPage);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$firstData = ($dataForEachPage * $activePage) - $dataForEachPage;


$peoples = query("SELECT * FROM people ORDER BY people_id DESC LIMIT $firstData,$dataForEachPage");

if (isset($_POST["submit"])) {
    $peoples = search($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People</title>
</head>

<body>
    <h1>People</h1>
    <a href="../../controller/people/addPeople.php">Add</a>
    <br><br>
    <form action="" method="post">
        <label for="keyword">Search People</label><br>
        <input type="text" name="keyword" id="keyword" size="50" autofocus placeholder="Search people by name"
            autocomplete="off">
        <button type="submit" name="submit">search</button>
    </form>
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
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>No.</th>
            <th>Photo</th>
            <th>Aksi</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Birth Place</th>
            <th>Description</th>
        </tr>
        <?php $i = 1 ?>
        <?php foreach ($peoples as $people) : ?>
        <tr>
            <td><?= $i ?></td>
            <td><img style="height: 25%;" src="../../img/people/<?= $people["photo"]; ?>" alt=""></td>
            <td><a href="../../controller/people/updatePeople.php?id=<?= $people["people_id"]; ?>">Ubah</a>|<a
                    href="../../controller/people/deletePeople.php?id=<?= $people["people_id"]; ?>"
                    onclick="return confirm('yakin?')">Hapus</a></td>
            <td><?= $people["name"] ?></td>
            <td><?= $people["birthday"] ?></td>
            <td><?= $people["birth_place"] ?></td>
            <td><?= $people["description"] ?></td>
        </tr>
        <?php $i++ ?>
        <?php endforeach ?>
    </table>
</body>

</html>