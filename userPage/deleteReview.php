<?php
session_start();
require("../database/dbMovie.php");
$id = $_GET['id'];
$userId = $_SESSION['id'];
$query = "DELETE FROM review WHERE user_id=$userId AND movie_id='$id'";
if (mysqli_query($conn, $query)) {
    $avgScore = query("SELECT AVG(score) FROM review WHERE movie_id='$id'")[0];
    $finalScore = intval($avgScore["AVG(score)"]);
    mysqli_query($conn, "UPDATE movie SET score=$finalScore WHERE movie_id='$id'");
    header('Location: detail.php?id=' . $id);
}