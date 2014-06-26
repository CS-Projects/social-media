<?php 
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title> Üye kayıt </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<a href="index.php">Ana sayfa</a> | <a href="uye_giris.php">Giriş</a>
<h2>Üye kayıt</h2>
<form method="post" action="">
    Adınız soyadınız:<br />
	<input type="text" name="ad" /><br />
	Eposta adresiniz:<br />
	<input type="text" name="email" /><br />
	Şifreniz:<br />
	<input type="text" name="sifre" /><br />
	<input type="submit" />
</form>
<?php
if(isset($_POST['ad']) && isset($_POST['sifre']) && isset($_POST['email'])){
require_once('db.php');

/* hata kontrolü yapalım */
if ($db->connect_errno) {
    printf("Bağlantı hatalı: %s\n", $db->connect_error);
    exit();
}
$ad = htmlspecialchars($_POST['ad'], ENT_QUOTES);

if(trim($_POST['ad']) !='' && trim($_POST['sifre']) !=''){
if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$db->query("INSERT INTO uye(ad,sifre,email,ip) VALUES('$ad','md5({$_POST['sifre']})','{$_POST['email']}','{$_SERVER['REMOTE_ADDR']}')");
	if($db->errno==1062){
		echo 'Girdiğiniz eposta adresi zaten kayıtlı';
	}elseif($db->errno){
		echo "Sorgu hatası: (" . $db->errno . ") " . $db->error;
	}else{
		$_SESSION['giris']=$db->insert_id;
		header("Location: profil.php"); 
	}
 }
}else{
	echo 'Lütfen adınızı soyadınızı ve şifrenizi giriniz';
}
/* Bağlantıyı kapatalım */
$db->close();
}
ob_end_flush();
?>
 </body>
</html>
