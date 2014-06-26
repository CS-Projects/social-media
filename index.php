<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
session_start();
if($_GET['onay'] && !$_SESSION['giris']){
   header("location: uye_giris.php");
   exit();
}
?>
<!DOCTYPE html>
<html>
 <head>
  <title> Sosyal paylaşım uygulaması </title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="site.css" />
<script src="jquery.min.js"></script>
<script src="jquery.timeago.js"></script>
<script>
$(document).ready(function() {
$.ajaxSetup({ cache: false });
$("abbr.timeago").timeago();
$('.mesaj>span.sil').live("click",function() {
	if(confirm('Silmek istediğinden eminmisin?')){
	var ustbag = $(this).parent();
	var id=ustbag.attr('id').replace('kayit-','');
	var istek={mesaj_id:id};
  $.post('mesaj_sil.php',istek , function(cevap) {
	 ustbag.slideUp(300,function(){ ustbag.remove(); });
   });
   }
 });
$('.yorum>span.sil').live("click",function() {
	if(confirm('Silmek istediğinden eminmisin?')){
	var ustbag = $(this).parent();
    var id = ustbag.attr('id').split('-');	
   $.post('yorum_sil.php',{mesaj_id:id[1],yorum_id:id[2]} ,function(cevap) {
    ustbag.slideUp(300,function(){ ustbag.remove(); });
  });
  }
});

$('#ara').focus(function(){
	 if($(this).val()=='insaları ve diğer şeyleri ara') $(this).val('');
	});
$('#ara').blur(function(){
	 if($(this).val()=='') $(this).val('insaları ve diğer şeyleri ara');
	});

$('#ara').bind('keyup',function() {
 $.post('ara.php',{ara:this.value} , function(cevap) {
    $('#aranan').html(cevap);
  });
});

$('.mesaj_yaz').focus(function(){
	 if($(this).html()=='Ne düşünüyorsun?') $(this).html('');
	 $('#yardim div').show();
	 $("#yardim div").animate({top: "20px"},1500); 
	});
$('.mesaj_yaz').blur(function(){
	 if($(this).html()=='') $(this).html('Ne düşünüyorsun?');
     $("#yardim div").animate({ top: "-200px" }, 1500, function() { $("#yardim div").hide(); });
	});

$('.mesaj_yaz').live("keypress",function(e) {
      $this=$(this);
	  $("#yardim div").hide();

  if((e.keyCode == 13) && ($this.html()!='')) {
	  var istek={mesaj:$this.html()};
	$.post('mesaj_yaz.php',istek , function(cevap) {
      $('#ic').prepend(cevap);
      $this.html('');
	  $("abbr.timeago").timeago();
	});
   }
 });

$('.yorum_yaz').focus(function(){
	 if($(this).html()=='Yorum yaz') $(this).html('');
	});
$('.yorum_yaz').blur(function(){
	 if($(this).html()=='') $(this).html('Yorum yaz');
	});

 $('.yorum_yaz').live("keypress",function(e) {
        $this=$(this);
  if($this.html().length >60){
        var h=($this.html().length/4)+15;
        $this.height(Math.floor(h));
     }
  if((e.keyCode == 13) && ($this.html()!='')) {
	  var id=$this.parent().attr('id').replace('kayit-','');
	  var istek={mesaj_id:id,yorum:$this.html()};
	$.post('yorum_yaz.php',istek , function(cevap) {
     $this.before(cevap);
     $this.html('');
	 $("abbr.timeago").timeago();
	});
   }
 });
 $(".uye").hover( 
        function() {$("#profil").show(); }, 
        function() {$("#profil").hide(); } 
    ); 

});
</script>
 </head>
 <body>
<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
require_once('db.php');
$uye_no=($_GET['uid'])? $_GET['uid']:$_SESSION['giris'];

/*Kayıtlı olmayan bir üye sistemi ziyaret ettiğinde bir kişi ile sistemi örnek olarak gösterelim*/
if(!isset($uye_no)){
 $uyeler=$db->query("SELECT * FROM uye WHERE uye_id ORDER BY uye_id  LIMIT 1"); 
 $uye_liste= $uyeler->fetch_assoc();
 $uye_no=$uye_liste['uye_id'];
}

$uye_no=$db->real_escape_string($uye_no);

if(is_numeric($_GET['onay'])){
	if($sorgu=$db->query("SELECT * FROM arkadas WHERE uye_id={$_GET['onay']} AND arkadas_id={$_SESSION['giris']}")){
       if($sorgu->num_rows ==0){
         if(!$db->query("INSERT INTO arkadas(uye_id, arkadas_id) VALUES({$_GET['onay']},{$_SESSION['giris']})")){
		     echo $db->error;
		 }
		 header("location: index.php?uid={$_GET['onay']}");
	   }
	}
 }
if(is_numeric($_GET['onayla'])){
	if($sorgu=$db->query("SELECT * FROM arkadas WHERE uye_id={$_SESSION['giris']} AND arkadas_id={$_GET['onayla']} AND onay=0")){
       if($sorgu->num_rows ==1){
         if(!$db->query("INSERT INTO arkadas(uye_id, arkadas_id,onay) VALUES({$_GET['onayla']},{$_SESSION['giris']},1)")){
		     echo $db->error;
		 }
        if(!$db->query("UPDATE arkadas SET onay=1 WHERE uye_id={$_SESSION['giris']} AND arkadas_id={$_GET['onayla']}")){
		    echo $db->error;
	    }
		header("location: index.php?uid={$_GET['onayla']}");
	 }
   }   
 }

if(is_numeric($_GET['iptal'])){
    if(!$db->query("DELETE FROM arkadas WHERE uye_id={$_SESSION['giris']} AND arkadas_id={$_GET['iptal']}")){
		echo $db->error;
	}
	header("location: index.php?uid={$_GET['iptal']}");
 }
$uyemiz=$db->query("SELECT * FROM uye WHERE uye_id='$uye_no'");
if($uyemiz->num_rows < 1 ){  header("location: uye_giris.php"); exit();}
$_SESSION['mesaj_id']=$uye_no;
$uye=$uyemiz->fetch_assoc();

$resim_yolu1 = "./images/".$uye['resim'];
list($width, $height, $type, $attr)= getimagesize($resim_yolu1); 

$yeni_en=140;
$yeni_boy=$yeni_en*$height/$width;
$yeni_boy= round($yeni_boy);

if(!$_SESSION['giris']){ $uyar=' | <a href="uye_giris.php">Üye değilsiniz giriş yapın</a>'; }
else{$uyar = ' | <a href="index.php?uid='.$_SESSION['giris'].'">Profil sayfan</a> | <a href="profil.php">Profil Resmini Değiştir</a> | <a href="cikis.php">Çıkış Yap</a>';}
echo <<<HTML
<div id="ana"><div id="slogan"><b style="font-size:1.5em">Fakebook</b><br/>
 <input type="text" id="ara" value="Ara" />
 <div id="aranan"></div></div><a href="index.php">Ana sayfa</a> $uyar
 
<div id="sol">
<div>
   <img src="$resim_yolu1" height="$yeni_boy" width="$yeni_en" class="uye"/>
</div>
HTML;

//Arkdaşlık durumunu sorgulayalım
$uyeler=$db->query("SELECT * FROM uye INNER JOIN arkadas ON uye.uye_id = arkadas.arkadas_id WHERE arkadas.uye_id=$uye_no"); 
$onay_id=array();
while ($uye_liste= $uyeler->fetch_assoc()) {

if($_SESSION['giris'] != $uye_no){
if($_SESSION['giris'] ==$uye_liste['arkadas_id'] && $uye_liste['onay']==1){
	$onay=1;
	$onay_id[]=$uye_liste['uye_id'];
 }
if($_SESSION['giris'] ==$uye_liste['arkadas_id'] && $uye_liste['onay']==0){
	$onay_bekliyor=1;
 }
}else{
  $onay=1;
  $onay_id[]=$uye_liste['arkadas_id'];
  if($uye_liste['onay']==0){
	  $bildirim.='<div style="background: yellow"><b>'. $uye_liste['ad'].'</b> sizinle arkadaş olmak istiyor<br /> <a href="?onayla='.$uye_liste['arkadas_id'].'">Onayla</a>
	  <a href="?iptal='.$uye_liste['arkadas_id'].'"> Reddet</a></div>';
  }
}

$resim_yolu = "./images/".$uye_liste['resim'];
list($width, $height, $type, $attr)= getimagesize($resim_yolu); 

$yeni_en=54;
$yeni_boy=$yeni_en*$height/$width;
$yeni_boy= round($yeni_boy);

echo <<<HTML
<div>
	<img src="$resim_yolu" height="$yeni_boy" width="$yeni_en" class="resim"/>
   <a href="?uid={$uye_liste['arkadas_id']}">{$uye_liste['ad']}</a>
</div>
HTML;

}
echo '</div><h3>'.$uye['ad'].'</h3>';

//Arkadaşlık durumunu tespit edelim. $onay varsa içeriği gösterelim, yoksa izin vermeyelim
if($onay || $_SESSION['giris']== $uye_no){
echo '<div id="ust">'.$bildirim.'<b id="yardim">
<div> Aşağıdaki popüler video paylaşım sitelerinde bulunan video adreslerini mesaj ve yorumlarınıza yazarak video ekleyebilirsiniz.<br />
  <a href="http://www.youtube.com" target="_blank">Youtube</a><br />
  <a href="http://vimeo.com" target="_blank">Vimeo</a><br />
  <a href="https://www.dailymotion.com/tr" target="_blank">Dailymotion</a><br />
  <a href="http://www.google.com/videohp" target="_blank">Google Video</a><br />
  <a href="http://www.twitch.tv/" target="_blank">Twitch</a><br />
  <a href="http://www.flickr.com" target="_blank">Flickr</a><br />
  </div></b>
<div contenteditable="true" class="mesaj_yaz">Ne düşünüyorsun?</div>
      <div id="ic">';

$sql=($_GET['uid'])? " AND gunce.mesaj_id='$uye_no' ORDER BY gunce_id":' GROUP BY gunce.uye_id';


$stmt=$db->query("SELECT * FROM gunce,uye WHERE gunce.uye_id=uye.uye_id $sql  DESC LIMIT 35");
 while($mesaj=$stmt->fetch_assoc()){
    $sorgu=$db->query("SELECT * FROM uye WHERE uye_id={$mesaj['uye_id']}");

    $uye= $sorgu->fetch_assoc();
	$yetki='<span class="sil" title="Bu içeriği silmek için tıklayınız">x</span>';
    $silme_izni=($mesaj['uye_id']==$_SESSION['giris'] || $_GET['uid']==$_SESSION['giris'])? $yetki:'';

echo <<<HTML
<div class="mesaj" id="kayit-{$mesaj['gunce_id']}">$silme_izni <img src="./images/{$uye['resim']}" class="resim1" />
<a href="?uid={$uye['uye_id']}"><b>{$uye['ad']}</b></a><br /> {$mesaj['yazi']}<br />
<abbr class="timeago" title="{$mesaj['tarih']}">{$mesaj['tarih']}</abbr>
HTML;
$uye_arkadasmi=$uye['uye_id']; // Mesaj sahibi ardaşmı, uye_id bilgisini elde edelim
$yorumlar=$db->query("SELECT * FROM yorum WHERE gunce_id={$mesaj['gunce_id']}");
while ($yorum= $yorumlar->fetch_assoc()) {
   $uyeler=$db->query("SELECT * FROM uye WHERE uye_id={$yorum['uye_id']}");
   $uye= $uyeler->fetch_assoc();
   $silme=($uye['uye_id']==$_SESSION['giris'] or $mesaj['uye_id']==$_SESSION['giris'])? $yetki:'';

echo <<<HTML
<div class="yorum" id="yorum-{$mesaj['gunce_id']}-{$yorum['yorum_id']}">{$silme}
<img src="./images/{$uye['resim']}" class="resim2" /><a href="?uid={$uye['uye_id']}"><b>{$uye['ad']}</b></a><br />
<q>{$yorum['yorum']}</q><br /><abbr class="timeago" title="{$yorum['tarih']}">{$yorum['tarih']}</abbr>
<br /></div>
HTML;
  }
 //Mesaj sahibi ardaşmı, uye_id bilgisini arkadaş uye_id bilgisinde araştıralım, varsa yorum yapabilsin
  if(in_array($uye_arkadasmi,$onay_id) || $_SESSION['giris']==$uye_arkadasmi){
	  echo '<img src="./images/'.$_SESSION['resim'].'" class="resim3" />';
	  echo '<div contenteditable="true" class="yorum_yaz">Yorum yaz</div></div>';
  }
}
$db->close();
// $onay yoksa uyarı bilgilerini ekrana yazalım 
}else{
	echo '<p>Arkadaş değilsiniz, içeriği görme izniniz yok</p>';
	if($onay_bekliyor){
	   echo 'Arkadaşlık isteğiniz <b>iletildi</b>, <i><b>onay</b></i> bekliyor';
    }else{      
	  echo '<a href="?onay='.$uye_no.'">Arkadaş olarak ekle</a>';
	}
}
?>
</div></div>
</body>
</html>
