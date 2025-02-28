<?php
    include("connection.php");
    $city = $_POST['municipality'];
    $sql = "SELECT DISTINCT brgyDesc FROM address WHERE citymunDesc = '$city'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    echo json_encode($result);