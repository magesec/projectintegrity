# Megento Project Integrity Checker
![alt tag](http://magemojo.com/files/editcore.png)

The Mage Project Integrity Checker checks a magento install for modified core files for Magento Community editions without having to download a base copy to compare it to. The comparison files are downloaded directly from this repo as needed by the script. The comparison files for MAgento 1 versions are also based off of installs that are fully patched. 

The mageintegriycheck.php file is the only requirement to use.

Usage: php mageintegriycheck.php <path to magento root>

Any modified core file will be returned.