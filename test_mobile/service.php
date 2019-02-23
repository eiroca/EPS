<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2019 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.3
 * @link http://www.eiroca.net
 */
require_once ("../lib/eps/eps.php");
global $CONFIG;
$CONFIG["URL_portal"] = "index.php";
$CONFIG["URL_service"] = "service.php";
$CONFIG["URL_download"] = "download.php";
global $CONTEXT;
initContext();
$CONTEXT->process();
?>
