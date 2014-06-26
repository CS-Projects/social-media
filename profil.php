<?php
ob_start(); 
session_start(); 
if(!$_SESSION['giris']){
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title> Profil resmi yükle </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<a href="index.php">Ana sayfa</a> | <a href="index.php?uid=<?php echo $_SESSION['giris'];?>">Profil sayfan</a>
<h3>Profil resmi yükle</h3>
<form method="post" action="" enctype="multipart/form-data">
	<input type="file" name="profil" /><br /><input type="submit" />
</form>
<?php
$resim_yolu = "./images";
if($_FILES){
if (preg_match("/^(.*.jpeg|.*.jpg|.*.png|.*.gif)/i", $_FILES['profil']['name'])){
list($width, $height, $type, $attr) = getimagesize($_FILES['profil']['tmp_name']);

	if ($width > 250 || $height > 540){
		echo "profil resminiz en fazla  250x540 boyutunda olamlıdır";
		exit();
		}
	}else{
        echo "Sadece resim dosyaları yükleyebilirsiniz";
		exit();
	}
  $ek = explode('.', $_FILES['profil']['name']);
 
  $ad=time().'.'.$ek[1];
  move_uploaded_file($_FILES['profil']['tmp_name'], $resim_yolu."/".$ad);
$resim_yolu = "./images/".$ad;
require_once('db.php');

/* hata kontrolü yapalım */
if ($db->connect_errno) {
    printf("Bağlantı hatalı: %s\n", $db->connect_error);
    exit();
}
if(!$db->query("UPDATE uye SET resim='$ad' WHERE uye_id='{$_SESSION['giris']}'")){
  die("Sorgu hatası: (" . $db->errno . ") " . $db->error);
}
header("Location: index.php?uid={$_SESSION['giris']}");
}
ob_end_flush();
?>
</body>
</html>
