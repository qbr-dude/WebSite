<?php 
    session_start();
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 

    if (empty($login) or empty($password)) 
    {
        exit ("fail login and password");
    }

    include ("connectBD.php");
 
    $result = mysqli_query($db, "SELECT `login`, `password`, `type` FROM `Users` WHERE `login`='$login'");
    $myrow = mysql_fetch_assoc($result);
    if (empty($myrow['login']))
    {
        exit ("fail login");
    }
    else 
    {
        if ($myrow['password']==md5($pass)) 
        {
            $_SESSION['login']=$myrow['login']; 
            $_SESSION['type']=$myrow['type'];
        echo "true";
        }
        else 
        {
            exit ("fail pass");
        }
    }
?>