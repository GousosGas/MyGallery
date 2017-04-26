<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php";?>
<?php

//call of logout method from session class and redirect to login.php page

$session->logout();
redirect("../album.php")

?>