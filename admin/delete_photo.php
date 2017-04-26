<?php /*include("includes/init.php"); */?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/init.php";?>
<?php if(!$session->is_signed_in()){redirect("login.php");}?>
<?php

    $photo = Photo::find_by_id($_GET['id']);

    if($photo){
       $photo->delete_photo();
        redirect("photos.php");
    }else{
        redirect("photos.php");
    }


?>

