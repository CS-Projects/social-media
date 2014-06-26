<?php
session_start();
header("Cache-Control: no-cache");
if (!$_SESSION['giris'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') die();
require_once('db.php');
$stmt=$db->prepare("DELETE FROM yorum WHERE yorum_id=? AND gunce_id=?");
$stmt->bind_param('ii',$_POST['yorum_id'],$_POST['mesaj_id']);
$stmt->execute();
echo $stmt->affected_rows;
$stmt->close();
$db->close();
?>
