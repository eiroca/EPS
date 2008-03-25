<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR . "core/plugins/function.link.php");
function smarty_function_navlink($params, &$smarty) {
  global $PAGE;
  $links = $PAGE->getFooterLinks();
  if ($links) {
    foreach ($links as $link) {
      $l = & getResourceById("TLink", $link);
      render_link($l);
    }
  }
}
?>