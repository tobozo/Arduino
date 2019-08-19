<?php

@mkdir("arm");

ob_start();
file_put_contents("deauther.zip", file_get_contents("https://github.com/tobozo/Arduino/archive/deauther.zip"));
$ret = ob_get_contents();
ob_end_clean();
if(trim($ret)!='') die($ret);
// calculate the sha256 sum of the downloaded archive
$sha256sum = trim(shell_exec("sha256sum deauther.zip |cut -d' ' -f1"));
// find the sha256 sum in the current json file
$json = json_decode( file_get_contents("package_deauther_index.json"), true);
$currentsha256sum = trim(end(explode("SHA-256:", $json['packages'][0]['platforms'][0]['checksum'])));
// some sanity check
if(trim($currentsha256sum)=='') die('sha sum failed\n');
$filesize = filesize('deauther.zip');
if($filesize <= 0) die('file download failed\n');
// compare buddies
if( $currentsha256sum != $sha256sum) {
  echo "SHA-256 sum changed!\nOLD: $currentsha256sum\nNEW: $sha256sum\nWill proceed with updating the JSON\n";
} else {
  if(! isset( $_GET['force'] ) ) {
    unlink('deauther.lock');
    die("SHA-256 sum is unchanged, quitting\n");
  }
}

$jsontpl = file_get_contents("package_deauther_index.tpl.json");
$jsonout = str_replace("{sha256sum}", trim($sha256sum), $jsontpl);
$jsonout = str_replace("{filesize}", trim($filesize), $jsonout);
file_put_contents("package_deauther_index.json", $jsonout);


$jsonARMtpl = file_get_contents("package_deauther_index.ARM.tpl.json");
$jsonout = str_replace("{sha256sum}", trim($sha256sum), $jsonARMtpl);
$jsonout = str_replace("{filesize}", trim($filesize), $jsonout);
file_put_contents("arm/package_deauther_index.json", $jsonout);
