<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
header("Cache-Control: no-cache");
if (!$_SESSION['giris'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') die();
require_once('db.php');
$ara=$db->real_escape_string($_POST['ara']);
 if($ara){
  echo '<div id="ara_liste">';
   $uyeler=$db->query("SELECT uye_id, ad,resim FROM uye WHERE ad LIKE '%$ara%'");
		while ($uye= $uyeler->fetch_assoc()) {
          echo '<p><img src="./images/'.$uye['resim'].'" class="resim2" alt="'.$uye['ad'].'" /><br />
		  <a href="?uid='.$uye['uye_id'].'">'.$uye['ad'].'</a></p>';
   }
   echo '</div>';
 }
?>
