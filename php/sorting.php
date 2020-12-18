<?php
   session_start();
   
   $sort_type = array_keys($_POST);

   if(count($sort_type) == 1) {
       $_SESSION['sort'] = 1;
       $_SESSION['sort_type'] = $sort_type[0];
       $_SESSION['set_scroll'] = 1;
   }

   header('Location: index.php');
?>