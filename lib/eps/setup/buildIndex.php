<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function buildIndex($fname, $path_data, $allowed_ext) {
	$f = fopen($fname, 'w+');
	fwrite($f, "[main]\n");
	$cat = array ();
	$cat_id = '';
	$dir = opendir($path_data);
	$id = 0;
	while (($file = readdir($dir)) !== false) {
		if (substr($file, 0, 1) != '.') {
			if (is_dir($path_data . DIR_SEP . $file)) {
				$cat_id = $cat_id . ' ' . $id;
				$cat[$id]['caption'] = $file;
				$id += 1;
			}
		}
	}
	closedir($dir);
	fwrite($f, sprintf("categories =%s\n", $cat_id));
	fwrite($f, "\n");
	unset($base_data);
	$data = null;
	foreach ($cat as $cid => $info) {
		$dname = $info['caption'];
		$path = $path_data . DIR_SEP . $dname . DIR_SEP;
		$dir = opendir($path);
		$fid = 0;
		$files = '';
		unset($base_data);
		if (file_exists($path . 'desc.ini')) {
			$base_data = parse_ini_file($path . 'desc.ini');
		}
		while (($file = readdir($dir)) !== false) {
			if (substr($file, 0, 1) != '.') {
				$img = $path . $file;
				if (is_file($img)) {
					$pi = pathinfo($img);
					$ext = '.' . $pi['extension'];
					if (!in_array(strtolower($ext), $allowed_ext)) continue;
					$id = $cid . '_' . $fid;
					$name = basename($img, $ext);
					$files = $files . ' ' . $id;
					fwrite($f, sprintf("[file_%s]\n", $id));
					unset($data);
					if (isset($base_data)) {
						foreach ($base_data as $nam => $val) {
							$data[$nam] = $val;
						}
					}
					if (file_exists($path . $name . '.ini')) {
						$tmp = parse_ini_file($path . $name . '.ini');
						foreach ($tmp as $nam => $val) {
							$data[$nam] = $val;
						}
					}
					if (!isset($data['caption'])) {
						$data['caption'] = $name;
					}
					$data['path'] = get_absolute_path($path . DIRECTORY_SEPARATOR);
					$data['file'] = $file;
					$data['basename'] = $name;
					foreach ($data as $nam => $val) {
						fwrite($f, sprintf("%s = \"%s\"\n", $nam, $val));
					}
					fwrite($f, "\n");
					$fid += 1;
				}
			}
		}
		fwrite($f, sprintf("[category_%s]\n", $cid));
		fwrite($f, sprintf("caption = \"%s\"\n", $info['caption']));
		fwrite($f, sprintf("files =%s\n", $files));
		fwrite($f, "\n");
		closedir($dir);
	}
	fclose($f);
}
?>