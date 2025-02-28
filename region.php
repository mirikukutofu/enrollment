<?php
    include("connection.php");
    $sql = "SELECT DISTINCT regDesc from address";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    echo json_encode($result);
    ?>