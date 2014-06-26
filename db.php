<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED);
$db= new mysqli('localhost', 'root', 'password', 'sosyal');
if($db->connect_error){
	die($mysqli->connect_error);
	}
$db->set_charset("utf8");
function oembed($url=''){
	$oembed= array (
	  'http://vimeo.com/api/oembed.xml?url=$1&format=json',
	  'http://www.flickr.com/services/oembed/?url=$1&format=json',
	  'http://api.5min.com/oembed.json?url=$1',
	  'http://www.youtube.com/oembed?url=$1&format=json',
	  'http://www.youtube.com/oembed?url=$1&format=json'
	);
	$desen=array(
	'/http:\/\/(?:www\.)?vimeo\.com\/([a-zA-Z0-9+&@#\/%=~_|?]+)/m',
	'/http:\/\/(?:www\.)?flickr\.com\/photos\/([a-zA-Z0-9+&@#\/%=~_|?]+)/m',
	'/http:\/\/(?:www\.)?5min\.com\/Video\/([a-zA-Z0-9\-_\/]+)/m',
	'/http:\/\/(?:www\.)?youtube.*watch\?v=([a-zA-Z0-9\-_]+)/m',
	'/http:\/\/(?:www\.)?youtu.be\/([a-zA-Z0-9\-_]+)/m',
	);
	if($url=='') return false;
	$html=''; $yeni='';
	for($i=0;$i<=count($desen)-1;$i++){
		if(preg_match($desen[$i],$url,$a)){
			 $json = @file_get_contents(str_replace('$1',$a[0],$oembed[$i]));
			 $veri= @json_decode($json);
		  if($veri->url){
			 $width=$veri->width/4;  $height=$veri->height/4;
			 $html ='<img src="'.$veri->url.'" width="'.$width.'" height="'.$height.'"/>';
		   }else{
			  $html=$veri->html.'<br/>'; 
			  $html=preg_replace('/width=.*? height=.*?/', 'width="300" height="200"', $html);
			}
			 $yeni.="<a href='".$a[0]."' target='_blank'>".$a[0]."</a> <br />".$html;
			 $yeni= str_replace($a[0],$yeni, $url);
		}
	  }
	  if($yeni==''){ return $url;} else{ return $yeni;}
}
?>
