<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function writePages(&$f, &$basepath, $pathdata, $name, $parent) {
	$dir = opendir($basepath . $pathdata);
	$valid = file_exists($basepath . $pathdata . '/metadata.inc');
	if ($name) {
		fwrite($f, sprintf("[%s]\n", $name));
	}
	fwrite($f, sprintf("path=\"%s\"\n", $pathdata));
	if ($parent) {
		fwrite($f, sprintf("parent=%s\n", $parent));
	}
	fwrite($f, sprintf("valid=%s\n", $valid));
	fwrite($f, "\n");
	while (($file = readdir($dir)) !== false) {
		if (substr($file, 0, 1) != '.') {
			$fullpath = $pathdata . '/' . $file;
			if (is_dir($basepath . $fullpath)) {
				if ($name) {
					$newname = $name . '_' . $file;
				}
				else {
					$newname = $file;
				}
				writePages($f, $basepath, $fullpath, $newname, $name);
			}
		}
	}
	closedir($dir);
}

function buildWebIndex($fname, $basepath = './', $path = 'pages') {
	$f = fopen($fname, 'w+');
	writePages($f, $basepath, $path, null, null);
	fclose($f);
}
?>