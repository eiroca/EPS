<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR . 'core' . DIR_SEP . 'plugins' . DIR_SEP . 'WML' . DIR_SEP . 'function.hr.php');
require_once (EPS_DIR . 'core' . DIR_SEP . 'plugins' . DIR_SEP . 'function.link.php');

function smarty_function_navlink($params, &$smarty) {
	global $PAGE;
	$links = $PAGE->getFooterLinks();
	if ($links) {
		echo render_hr('50');
		echo ('<p>');
		foreach ($links as $link) {
			$l = & getResourceById('TLink', $link);
			render_link($l);
		}
		echo ('</p>');
	}
}
?>