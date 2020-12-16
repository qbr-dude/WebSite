<?php
    include_once "connectBD.php";
    $user_login = $_SESSION['current_user'];
    $result = mysqli_query($db, "SELECT * FROM `Basket` WHERE `id_login_user` = $user_login");

    $_SESSION['basket'] = $result;
    function getItemById($id) {
        $result = mysqli_query($db, "SELECT `name` FROM `Products` WHERE `id` = $id");
        return mysqli_fetch_assoc($result);
    }
    
    header('Location: index.php');
?>