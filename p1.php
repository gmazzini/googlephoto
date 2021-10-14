<?php 

$p1="AF1QipO77HMMFpTErNkmUK5LuXMrSpDeR5O64nJOb2tx4ATc4fc-YoPSAeaXg_pxkDduiQ";
$p2="VFhVdWpHU0p4Z2M5dzRXLVV6MndrNGhyRFdYWWNR";

$url="https://photos.google.com/share/$p1?key=$p2";
$html=file_get_contents($url);
$re='/<script nonce="[^"]+">AF_initDataCallback\(\{[^<]+, data:([^<]+)\}\);<\/script>/m';
preg_match_all($re,$html,$matches,PREG_SET_ORDER,0);
$json=str_replace(', sideChannel: {}', '',$matches[0][1]);
$data=json_decode($json,true);
$qq=$data[1];

$i=1;
foreach($qq as $v){

  echo $i." ".$v[0]."\n";
  $url="https://photos.google.com/share/$p1/photo/$v[0]?key=$p2";
  $html=file_get_contents($url);
  preg_match_all($re,$html,$matches,PREG_SET_ORDER,0);
  $json=str_replace(', sideChannel: {}', '',$matches[0][1]);
  $data=json_decode($json,true);
  $title=$data[10];
  echo $i." ".$title."\n";
  
  echo $i." ".$v[1][0]."\n";
  $myjpg=file_get_contents($v[1][0]);
  file_put_contents($title.".jpg",$myjpg);
  $i++;
  if($i>3)break;
}

?>
