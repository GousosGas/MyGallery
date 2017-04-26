<?php /*include("includes/init.php"); */?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/init.php";?>
<?php if(!$session->is_signed_in()){redirect("login.php");}?>
<?php

$user = User::find_by_id($_GET['id']);

if($user){
    $user->delete();
    redirect("users.php");
}else{
    redirect("users.php");
}


?>

