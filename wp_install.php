<?php

// check install directory
$dir = dirname($_SERVER['SCRIPT_FILENAME']);

// check if directory is writable
if ( ! is_writable($dir))
	die('please make directory writable');

// download wordpress
$wp = 'http://wordpress.org/latest.zip';
$tmp = tempnam(sys_get_temp_dir(), 'wp');
$handle = fopen($tmp, 'w');
fwrite($handle, file_get_contents($wp));
fclose($handle);

$zip = new ZipArchive;
// open archive
if ($zip->open($tmp) !== TRUE)
	die ('Could not open archive');

// extract contents
$zip->extractTo($dir);
$zip->close();

// move wordpress files to root directory
exec("mv {$dir}/wordpress/* {$dir}/");
// chmod all files to 755
exec("chmod -R 755 {$dir}");

// delete temp file
unlink($tmp);
// delete wordpress directory
rmdir($dir . '/wordpress');
// unlink install php file
unlink($_SERVER['SCRIPT_FILENAME']);

print 'finished installing wp';