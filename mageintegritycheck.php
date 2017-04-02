<?php
$checkpath = $argv[1];
$checksumurl = 'https://github.com/magesec/projectintegrity/raw/master/checksums/';



if (!file_exists($checkpath)) {
  echo "Filepath not found!";
  exit;
}

if (file_exists($checkpath."/app/Mage.php")) {
  #Should be a magento 1 install
  require $checkpath."/app/Mage.php";
  $version = Mage::getVersion();
} else if (file_exists($checkpath."/app/bootstrap.php")) {
  #should be a magento 2 install
  $composerjson = file_get_contents($checkpath."/composer.json");
  $composerjson = str_replace('magento/product-community-edition','version',$composerjson);
  $composer = json_decode($composerjson);
  $version = $composer->require->version;
} else {
  echo "Could not determine Magento version, is this a magento install?\n";
  exit;
}

$json = file_get_contents($checksumurl.'checksum-'.$version.'.json');

if (!$json) {
  print "Could not find checksum file for this version of magento\n";

}

$checks = json_decode($json);

foreach ($checks as $file=>$goodsha) {
  if (file_exists($checkpath."/".$file)) {
    $filesha = sha1_file($checkpath."/".$file);
    if ($filesha != $goodsha) {
      print $file.' has been modified.'."\n";
    }
  } else {
    print $file.' was not found.'."\n";
  }
}
?>