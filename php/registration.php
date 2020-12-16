<?php 
session_start();

$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING); 


if(mb_strlen($login) < 5 || mb_strlen($login) > 50)
{
	// "Недопустимая длина логина"
	$errors['login_lenght'] = 1;
}
$pass = md5($pass."md5encryption");

include ('connectBD.php');

$result = mysql_query("SELECT login FROM Users WHERE login = '$login'", $bd);
$myrow = mysql_fetch_array($result);
if (!empty($myrow['id'])) {
	$errors['login_compare'] = 1;
}


if(count($errors) == 0) {
	$today = date("y.m.d h:m:s"); 
	mysql_query ("INSERT INTO Users (login, password, email, type, date)
					VALUES('$login', '$pass', '$email', 0, '$today')");
}

if(count($errors) > 0) 
{	
	$_SESSION["registration"] = 1;
	$_SESSION["errors"] = $errors;
}
else 
{
	$_SESSION["registration"] = 0;
}


header('Location: DBItems.php');

?>