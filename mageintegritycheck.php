<?php
$checkpath = $argv[1];
$checksumurl = 'https://github.com/magesec/projectintegrity/raw/master/checksums/';



if (!file_exists($checkpath)) {
  echo "Filepath not found!";
}

if (!file_exists($checkpath."/app/Mage.php")) {
  echo "Could not find Mage.php, is this a magento install?";
} else {
  require $checkpath."/app/Mage.php";
  $version =  Mage::getVersion();
}

$json = file_get_contents($checksumurl.'checksum-'.$version.'.json');

$checks = json_decode($json);

foreach ($checks as $file=>$goodsha) {
  $filesha = sha1_file($checkpath."/".$file);
  if ($filesha != $goodsha) {
    print $file.' has been modified.'."\n";
  }
}
?>