<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function smarty_modifier_rss_date_parse($rss_date, $default_date = null) {
	if ($rss_date != '') {
		return parse_w3cdtf($rss_date);
	}
	elseif (isset($default_date) && $default_date != '') {
		return parse_w3cdtf($default_date);
	}
	else {
		return;
	}
}
?>
