<?php
$tables = '*';
$link = mysqli_connect("localhost", "root", "", "api");
mysqli_query($link, "SET NAMES 'utf8'");

$tables = array();
$result = mysqli_query($link, 'SHOW TABLES');
while($row = mysqli_fetch_row($result)){
  $tables[] = $row[0];
}

$return = '';
foreach($tables as $table){
  $result = mysqli_query($link, 'SELECT * FROM '.$table);
  $num_fields = mysqli_num_fields($result);
  $num_rows = mysqli_num_rows($result);

  $return.= 'DROP TABLE IF EXISTS '.$table.';';
  $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
  $return.= "\n\n".$row2[1].";\n\n";
  $counter = 1;

  for ($i = 0; $i < $num_fields; $i++){
    while($row = mysqli_fetch_row($result)){   
      if($counter == 1){
        $return.= 'INSERT INTO '.$table.' VALUES(';
      }else{
        $return.= '(';
      }

      for($j=0; $j<$num_fields; $j++){
        $row[$j] = addslashes($row[$j]);
        $row[$j] = str_replace("\n","\\n",$row[$j]);
        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
        if ($j<($num_fields-1)) { $return.= ','; }
      }

      if($num_rows == $counter){
        $return.= ");\n";
      } else{
        $return.= "),\n";
      }
      ++$counter;
    }
  }
  $return.="\n\n\n";
}

$files = glob("*.sql");
foreach($files as $file){
  unlink($file);
}

$fileName = 'backup.sql';
$handle = fopen($fileName,'w+');
fwrite($handle,$return);
if(fclose($handle)){
  echo "ok: " . $fileName;
  exit; 
}