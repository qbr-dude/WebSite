<?php
    include_once "connectBD.php";
    $result = mysqli_query($db, "SELECT * FROM `Products`");
    $allProducts = mysqli_fetch_assoc($result);
    print_r($allProducts);
?>