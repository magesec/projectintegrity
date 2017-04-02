<?php
$checkpath = $argv[1];

if (!file_exists($checkfile)) {
  echo "Filepath not found!";
}

if (!file_exists($checkfile."/app/Mage.php")) {
  echo "Could not find Mage.php, is this a magento install?";
} else {
  require $checkfile."/app/Mage.php";
  $version =  Mage::getVersion();
}


?>