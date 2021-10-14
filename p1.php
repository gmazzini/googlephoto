<?php
// non eccedere le 250 photo per album

$album=$argv[1];
echo "Album: $album\n";

$p1[1]="AF1QipO77HMMFpTErNkmUK5LuXMrSpDeR5O64nJOb2tx4ATc4fc-YoPSAeaXg_pxkDduiQ";
$p2[1]="VFhVdWpHU0p4Z2M5dzRXLVV6MndrNGhyRFdYWWNR";

$p1[2]="AF1QipPb-oQKtgwg_x3cVSEWgwsJ_ddicNK2I0bSTmMTsh7CdNlTuGLy_wTrq3aOSuoSIg";
$p2[2]="Z2F1SjV4dDJyTDFKempHcERDVWttbFI4YURhUTd3";

$url="https://photos.google.com/share/".$p1[$album]."?key=".$p2[$album];
$html=file_get_contents($url);
file_put_contents("check.html",$html);
$re='/<script nonce="[^"]+">AF_initDataCallback\(\{[^<]+, data:([^<]+)\}\);<\/script>/m';
preg_match_all($re,$html,$matches,PREG_SET_ORDER,0);
$json=str_replace(', sideChannel: {}', '',$matches[0][1]);
$data=json_decode($json,true);
$qq=$data[1];

$i=1;
foreach($qq as $v){
  echo $i." ".$v[0]."\n";
  $url="https://photos.google.com/share/$p1[$album]/photo/$v[0]?key=$p2[$album]";
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
}

?>
