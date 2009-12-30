<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR."core".DIR_SEP."plugins".DIR_SEP."function.icon.php");
function render_link(&$link) {
	global $CONTEXT;
	global $CONFIG;
	global $HANDSET;
	$filterquery = $link->filter;
	if ($filterquery) {
		$res = $CONTEXT->processFilter($filterquery);
		if ($res === false) {
			return;
		}
	}
	$url = $link->url;
	if ($url {0} == "#") {
		$ps = strpos($url, "#", 1);
		$what = substr($url, 1, $ps - 1);
		$parm = substr($url, $ps + 1);
		$url = $CONFIG["URL_$what"] . $parm;
	}
	if ($url) {
		echo ("<a href=\"$url\"");
		if ($link->access_key) {
			echo (" accesskey=\"$link->access_key\"");
		}
		echo (">");
		$cap = $link->caption;
		if ($link->icon) {
			$icon = & getResourceById("TIcon", $link->icon);
			if (render_icon($icon) && $cap) {
				echo "&nbsp;";
			}
		}
		echo ($cap);
		echo ("</a>");
		if (($link->style & 1) == 0) {
			echo $HANDSET->BR();
		}
	}
}
function smarty_function_link($params, &$smarty) {
	$ref = $params["ref"];
	if ($ref) {
		$link = & getResourceById("TLink", $ref);
	} else {
		$link = new TLink($params);
	}
	if ($link) {
		render_link($link);
	}
}
?>