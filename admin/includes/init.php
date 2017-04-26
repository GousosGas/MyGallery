<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT',$_SERVER["DOCUMENT_ROOT"]);
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');
defined('IMAGE_PATH') ? null : define('IMAGE_PATH', SITE_ROOT.DS.'admin'.DS.'images');
defined('STORAGE_PATH') ? null : define('STORAGE_PATH', "your_storage_path");


require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/configuration.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/Database.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/function.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/User.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/session.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/db_object.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/Photo.php";


?>