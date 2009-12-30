<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
global $CONTEXT;
global $DATA;
global $CONFIG;
$top = (int) $DATA["TOP"];
if (($top & 1) == 0) {
	@include $CONFIG["path_banner"]."banner.inc";
}
if (($top & 2) == 2) {
	@include $CONFIG["path_banner"]."search.inc";
}
?>
