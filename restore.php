<?php

$mysqli = new mysqli("localhost", "root", "", "api");
// $mysqli = new mysqli("mysql.hostmania.es", "u860838189_root", "EuA4XRpsJiBH", "u860838189_pos");

$ch = curl_init();
$url = 'https://raw.githubusercontent.com/jfdelarosa/api/master/backup.sql?token=AA_KOSh1_2JfQcea10_Ur3P91ozoJaTrks5bAHsjwA%3D%3D';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

if($mysqli->multi_query($data)){
  echo "ok";
}else{
  echo $mysqli->error;
}
?>