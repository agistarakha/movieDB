<?php
require("database/dbProductionCo.php");


//Pagination setup
$dataForEachPage = 2;
$dataCount = count(query("SELECT * FROM production_company"));
$pageCount = ceil($dataCount / $dataForEachPage);
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1;
$firstData = ($dataForEachPage * $activePage) - $dataForEachPage;

// get all data
$companies = query("SELECT * FROM production_company ORDER BY production_co_id DESC LIMIT $firstData,$dataForEachPage");

//Search
if (isset($_POST["submit"])) {
    $companies = search($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>company</title>
</head>

<body>
    <h1>company</h1>
    <a href="addProductionCompany.php">Add</a>
    <br><br>
    <!-- Search form -->
    <form action="" method="post">
        <label for="keyword">Search Comapny</label><br>
        <input type="text" name="keyword" id="keyword" size="50" autofocus placeholder="Search company by name"
            autocomplete="off">
        <button type="submit" name="submit">search</button>
    </form>
    <!-- Search form end -->
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
    <!-- Navigation End -->

    <!-- Data List -->
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Logo</th>
            <th>Aksi</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
        <!-- <?php $i = 1 ?> -->
        <?php foreach ($companies as $company) : ?>
        <tr>
            <td><?= $company["production_co_id"] ?></td>
            <td><img style="height: 25%;" src="img/productionCo/<?= $company["logo"]; ?>" alt=""></td>
            <td><a href="updateProductionCompany.php?id=<?= $company["production_co_id"]; ?>">Edit</a>|<a
                    href="deleteProductionCompany.php?id=<?= $company["production_co_id"]; ?>"
                    onclick="return confirm('yakin?')">Delete</a>
            </td>
            <td><?= $company["name"] ?></td>
            <td><?= $company["description"] ?></td>
        </tr>
        <?php $i++ ?>
        <?php endforeach ?>
    </table>
    <!-- Data List End -->


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
    <!-- Navigation End -->
</body>

</html>