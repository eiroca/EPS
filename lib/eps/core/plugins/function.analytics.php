<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function googleAnalyticsGetImageUrl($id) {
	$url = '/ga.php?utmac=' . $id . '&amp;utmn=' . rand(0, 0x7fffffff);
	$referer = $_SERVER['HTTP_REFERER'];
	$path = $_SERVER['REQUEST_URI'];
	if (empty($referer)) {
		$referer = '-';
	}
	$url .= '&amp;utmr=' . urlencode($referer);
	if (!empty($path)) {
		$url .= '&amp;utmp=' . urlencode($path);
	}
	$url .= '&amp;guid=ON';
	return $url;
}

function smarty_function_analytics($params, &$smarty) {
	$ID = $params['id'];
	echo '<div><img src="' . googleAnalyticsGetImageUrl($ID) . '" alt="" width="1" height="1" /></div>';
	return $out;
}
?>