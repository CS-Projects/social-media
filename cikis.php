<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
session_start();
require_once('db.php');
if(isset($_SESSION['giris'])){
   unset($_SESSION['giris']);
   header("Location: index.php");
}
?>
