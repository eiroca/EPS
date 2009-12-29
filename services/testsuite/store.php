<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
global $CONTEXT, $CONFIG;
require_once ("../../lib/eps/eps.inc");
$data = file_get_contents("php://input");
initContext();
$rr = trim($CONTEXT->touchCounter("req"));
$fname = $CONFIG["path_log"] . (int)$rr . ".txt";
$f = fopen($fname, "w+");
if ($_REQUEST["_P"] != "") {
	foreach($_REQUEST as $name => $value) {
		fwrite($f, $name . "=" . $value . "\n");
	}
}
else {
	fwrite($f, $data);
}
fclose($f);
?>
OK
