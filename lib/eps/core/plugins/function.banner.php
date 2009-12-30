<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR."core".DIR_SEP."plugins".DIR_SEP."function.link.php");
$banner_color_def = "#A981D3 #B08BD8 #B998DC #C1A3E0 #C7ABE2 #CBB3E6 #D5BFEA #DAC8EC #DFCFEF #EEE8F7";
define(BANNER_EMPTYSTR1, "&nbsp;");
define(BANNER_EMPTYSTR2, "<img src=\"static/img/o.gif\" alt=\"\" width=\"1\" heght=\"1\"/>");
function render_banner(&$params) {
	global $CONTEXT;
	$class = $params["class"];
	echo "<table class=\"$class\">";
	echo "<tr>";
	$i = 0;
	while (true) {
		$class = $params[$i . "_class"];
		$text = $params[$i . "_text"];
		$link = $params[$i . "_link"];
		if ($class) {
			echo "<td class=\"$class\">";
			$empty = true;
			if ($text) {
				echo $text;
				$empty = false;
			}
			if ($link) {
				$link = & getResourceById("TLink", $link);
				render_LINK($link);
				$empty = false;
			}
			if ($empty) {
				echo "&nbsp;";
			}
			echo "</td>";
		} else {
			break;
		}
		$i++;
	}
	echo "</tr>";
	echo "</table>";
}
function smarty_function_banner($params, &$smarty) {
	render_banner($params);
}
?>