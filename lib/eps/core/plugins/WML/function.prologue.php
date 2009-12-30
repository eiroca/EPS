<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
function smarty_function_prologue($params, &$smarty) {
	global $PAGE;
	global $HANDSET;
	$openCard = $params["openCard"];
	if ($openCard == NULL) {
		$openCard = true;
	}
	echo ("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>");
	echo ($HANDSET->getDocType());
	echo ("<wml>");
	if ($openCard) {
		$tit = $PAGE->getTitle();
		echo ("<card id=\"id\" title=\"" . $tit . "\">");
	}
}
?>