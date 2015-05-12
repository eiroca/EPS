<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR . 'core' . DIR_SEP . 'plugins' . DIR_SEP . 'function.link.php');

function smarty_function_sponsor($params, &$smarty) {
	global $CONFIG;
	global $CONTEXT;
	global $HANDSET;
	$path_data = $CONFIG['path_common'] . $CONFIG['relpath_resource'] . DIR_SEP . 'sponsor.ini';
	if (!file_exists($path_data)) {
		$path_data = $CONFIG['path_service'] . $CONTEXT->service->namespace . DIR_SEP . $CONFIG['relpath_resource'] . DIR_SEP . 'sponsor.ini';
	}
	$sponsor = parse_ini_file($path_data, true);
	$w = explode(' ', $sponsor['main']['weight']);
	$s = 0;
	foreach ($w as $e) {
		$s += (int)$e;
	}
	$i = rand(0, $s);
	$s = 0;
	$p = 0;
	foreach ($w as $e) {
		$w = (int)$e;
		$s += $w;
		$p += 1;
		if (($s >= $i) & ($w > 0)) {
			break;
		}
	}
	$def = $sponsor['link_' . $p];
	if ($def) {
		$link = new TLink($def);
		$text = $def['text'];
		if ($text) {
			echo $text . $HANDSET->BR();
		}
		render_link($link);
	}
}
?>