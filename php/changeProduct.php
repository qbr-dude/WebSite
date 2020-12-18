<?php 
//Изминение товара
session_start();

function can_upload($file)
{
    if($file['name'] == '')
	    return false;
	
	if($file['size'] == 0)
		return false;
	
	$getMime = explode('.', $file['name']);

	$mime = strtolower(end($getMime));

	$types = array('jpg', 'png', 'jpeg');
	
	if(!in_array($mime, $types))
		return false;
	
    return true;
}
  
function make_upload($file)
{	
	$name = mt_rand(0, 10000) . $file['name'];
	copy($file['tmp_name'], '../img/' . $name);
	return $name;
}
  
$idp = $_SESSION['edit_id'];
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$cost = filter_var(trim($_POST['cost']), FILTER_SANITIZE_STRING);
$type = filter_var(trim($_POST['type']), FILTER_SANITIZE_STRING); 

if (empty($name) or empty($cost)) 
{   
    
    $errors['not_all_data'] = 1;
}
else
{
    include ('connectBD.php');
    if(isset($_FILES['photo'])){
        $check = can_upload($_FILES['photo']);
        if($check == 1)
        {
            $img = make_upload($_FILES['photo']);
            $img = "../img/".$img;
            
            mysqli_query($db, "UPDATE `Products` SET `name` = '$name', `cost` = '$cost', `type` = '$type', `images` = '$img' WHERE `id` = '$idp'");
        }
        else
        {
            $errors['fail_image'] = 1;
        }
    } else {
        mysqli_query($db, "UPDATE `Products` SET `name` = '$name', `cost` = '$cost', `type` = '$type' WHERE `id` = '$idp'");
    }
}    
    header('Location: index.php');
?>