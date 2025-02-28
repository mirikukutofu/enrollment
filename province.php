<?php
    include("connection.php");
    $region = $_POST["region"];
    $sql = "SELECT DISTINCT provDesc FROM address WHERE regDesc = '$region'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    echo json_encode($result);