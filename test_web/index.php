<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once("../lib/eps/eps.inc");
if (!defined('BASEPATH_DIR')) {
  define('BASEPATH_DIR', dirname(__FILE__) . DIR_SEP);
}
initContext("web");
$CONTEXT->process();
?>