<?php
session_start();
header("Cache-Control: no-cache");
if (!$_SESSION['giris'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') die();
require_once('db.php');
$yazi=oembed(strip_tags($_POST['mesaj']));
$stmt=$db->prepare("INSERT INTO gunce(yazi,tarih,uye_id,mesaj_id) VALUES(?,?,?,?)");
$stmt->bind_param('ssii',$yazi,date("c"),$_SESSION['giris'],$_SESSION['mesaj_id']);
$stmt->execute();
$id=$db->insert_id;
if($stmt->affected_rows){
$sql = "SELECT * FROM uye WHERE uye_id='{$_SESSION['giris']}'";
if ($sorgu = $db->query($sql)) {
  $uye = $sorgu->fetch_row();
   echo '<div class="mesaj" id="kayit-'.$id.'"><span class="sil">x</span>
  <img src="'.$uye[4].'" class="resim" /><b>'.$uye[1].' </b>  '.$yazi.'<br />
  <abbr class="timeago" title="'.date("c").'">'.date("c").'</abbr>
  <div contenteditable="true" style="width:450px" class="yorum_yaz">Yorum yaz</div>
  </div>';
  $sorgu->close();
   }
 }
$stmt->close();
$db->close();
?>
