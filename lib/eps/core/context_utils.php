<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function _utils_touchCounter($name) {
	global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
	$counters_filename = $CONFIG['path_counters'];
	$accesscount = 0;
	$fname = $counters_filename . $name . '.txt';
	if (file_exists($fname)) {
		$f = fopen($fname, 'r+');
	}
	else {
		$f = fopen($fname, 'w+');
	}
	$line = fgets($f, 128);
	$accesscount = $line;
	rewind($f);
	fputs($f, $accesscount + 1);
	fclose($f);
	return $accesscount;
}

function _utils_errorTrace($msg) {
	global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
	$errLog = $CONFIG['path_log'] . $CONFIG['file_errorlog'];
	if ($errLog) {
		$f = fopen($errLog, 'a+');
		fputs($f, $msg . "\n");
		fclose($f);
	}
}
?>