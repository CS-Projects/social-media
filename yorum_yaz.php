<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
session_start();
header("Cache-Control: no-cache");
if (!$_SESSION['giris'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') die();
require_once('db.php');
$yorum=oembed(strip_tags($_POST['yorum']));
$stmt=$db->prepare("INSERT INTO yorum(yorum,gunce_id,uye_id,tarih) VALUES(?,?,?,?)");
$stmt->bind_param('siis', $yorum, $_POST['mesaj_id'], $_SESSION['giris'], date("c"));
$stmt->execute();
$id=$db->insert_id;
if($stmt->affected_rows){
$sql = "SELECT * FROM uye WHERE uye_id='{$_SESSION['giris']}'";
if ($sorgu = $db->query($sql)) {
  $uye = $sorgu->fetch_row();
  $idler=$_POST['mesaj_id'].'-'.$id;
  echo '<div class="yorum" id="yorum-'.$idler.'"><span class="sil">x</span>
  <img src="./images/'.$uye[4].'" class="resim2" /><b>'.$uye[1].' </b>
  <q>'.$yorum.'</q><br />
  <abbr class="timeago" title="'.date("c").'">'.date("c").'</abbr><br />
  </div>';
  $sorgu->close();
   }
 }
$stmt->close();
$db->close();
?>
