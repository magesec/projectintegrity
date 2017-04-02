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
} else if (file_exists($checkpath."app/etc/env.php")) {
  #should be a magento 2 install
  require $checkpath."/app/bootstrap.php";
  $version = \Magento\Framework\AppInterface::VERSION;
} else {
  echo "Could not determine Magento version, is this a magento install?\n";
  exit;
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