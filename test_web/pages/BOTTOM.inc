<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2019 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.3
 * @link http://www.eiroca.net
 */
global $TEMPLATE;
global $CONFIG;
global $DATA;
$TEMPLATE->bottom();
$top = (int)@$DATA["TOP"];
if (($top & 4) == 0) {
  @include $CONFIG["path_banner"] . "search.inc";
}
?>