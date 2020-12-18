<?php 
    session_start();
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 

    $_SESSION['authorisation'] = 1;

    if (empty($login) or empty($pass)) 
    {
        $errors['not_login_pass'] = 1;
    }

    include ("connectBD.php");
 
    $result = mysqli_query($db, "SELECT `login`, `password`, `type` FROM `Users` WHERE `login`='$login'");
    $myrow = mysqli_fetch_assoc($result);
    if (empty($myrow['login']))
    {
        $errors['login_wrong'] = 1;
    }
    else 
    {
        if ($myrow['password']==md5($pass.md5encryption)) 
        {
            $_SESSION['current_user']=$myrow['login']; 
            $_SESSION['user_type']=$myrow['type'];
            $_SESSION['authorisation'] = 0;
        }
        else 
        {
            $errors['pass_wrong'] = 1;
        }
    }
    header('Location: index.php');
?>