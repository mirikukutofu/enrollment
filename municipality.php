<?php
    include("connection.php");
    $province = $_POST['province'];
    $sql = "SELECT DISTINCT citymunDesc FROM address WHERE provDesc = '$province'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    echo json_encode($result);