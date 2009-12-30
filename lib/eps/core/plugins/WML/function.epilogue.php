<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
function smarty_function_epilogue($params, &$smarty) {
	global $content;
	echo $content;
	$closeCard = $params["closeCard"];
	if ($closeCard == NULL) {
		$closeCard = true;
	}
	if ($closeCard) {
		echo ("</card>");
	}
	echo ("</wml>");
}
?>