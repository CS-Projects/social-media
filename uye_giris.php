<?php
//for logging in your account
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
session_start();
require_once('db.php');
 // abc veritabanını seç
$msj='Lütfen giriş yapınız';
if(isset($_POST['email']) && isset($_POST['sifre'])) {
$email=$db->real_escape_string($_POST['email']);
$sifre=md5($_POST['sifre']);
$result = $db->query("SELECT * FROM uye WHERE email='$email' AND sifre='$sifre'");
     if($result->num_rows) {
		 $row = $result->fetch_assoc();
         $_SESSION['giris'] = $row['uye_id'];
		 $_SESSION['resim'] = $row['resim'];
		 $result->free();
		 header("location: index.php");
     }
	 $msj='Eposta adresiniz yada şifreniz hatalı';
}
if($_SESSION['giris']){
header("Location: index.php?uid={$_SESSION['giris']}");
}else{ 
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<b>'.$msj.'</b>
<form method="post" action="">
Email: <input type="text" name="email" /><br />
Şifre: &nbsp;<input type="password" name="sifre" />
<input type="submit" value="Giriş"/>
</form>
<a href="uye_kayit.php">Bir dakikadan az sürede kayıt olun</a>';
exit();
}
$db->close();
?>
//
