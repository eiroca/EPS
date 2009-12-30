<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR."core".DIR_SEP."plugins".DIR_SEP."function.link.php");
function smarty_function_navlink($params, &$smarty) {
	global $PAGE;
	if ($PAGE != null) {
		$links = $PAGE->getFooterLinks();
	}
	if ($links) {
		echo ("<div class=\"CENTER\"><hr class=\"HR25\"/></div>");
		echo ("<p>");
		foreach ($links as $link) {
			$l = & getResourceById("TLink", $link);
			render_link($l);
		}
		echo ("</p>");
	}
}
?>