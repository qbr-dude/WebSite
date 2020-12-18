<?php 
session_start();
  
$idp = filter_var(trim($_POST['idProduct']), FILTER_SANITIZE_STRING);

$user = $_SESSION['current_user'];
	  
include ('connectBD.php');
$result = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `Basket` WHERE (`id_prod` = '$idp' AND `id_login_user` = '$user')"));

if(isset($result)) { 
	$icount = $result['i_count'];
	$count = $icount + 1;
	mysqli_query ($db, "UPDATE `Basket`
		SET `i_count`='$count' WHERE (`id_prod` = '$idp') AND (`id_login_user` = '$user')");
} 
else {
	$count = 1;
	mysqli_query ($db, "INSERT INTO `Basket` (`id_prod`, `id_login_user`, `status`, `i_count`)
		VALUES('$idp', '$user', 'awaiting', '$count')");
}
   
unset($idp);
header('Location: index.php');
?>