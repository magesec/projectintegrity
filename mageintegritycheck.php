<?php
$checkpath = $argv[1];
$checksumurl = 'https://github.com/magesec/projectintegrity/raw/master/checksums/';



if (!file_exists($checkpath)) {
  echo "Filepath not found!";
  exit;
}

if (file_exists($checkpath."app/etc/local.xml")) {
  #Should be a magento 1 install
  if (!file_exists($checkpath."/app/Mage.php")) {
    echo "Could not find Mage.php, is this a magento install?\n";
    exit;
  } else {
    require $checkpath."/app/Mage.php";
    $version = Mage::getVersion();
  }
} else if (file_exists($checkpath."app/etc/env.php")) {
  if (!file_exists($checkpath."/app/bootstrap.php")) {
    echo "Could not find Mage.php, is this a magento install?\n";
    exit;
  } else {
    require $checkpath."/app/bootstrap.php";
    $version = \Magento\Framework\AppInterface::VERSION;
  }
} else {
  echo "Could not determine Magento major version, is this a magento install?\n";
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