<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
function smarty_function_set($params, &$smarty) {
  $kind = $params["kind"];
  $id = $params["id"];
  $attr = $params["name"];
  $val = $params["value"];
  global $_f_c_registry;
  $res = & $_f_c_registry[$kind][$id];
  if ($res && $attr) {
    unset ($res-> $attr);
    if ($val) {
      $res-> $attr = $val;
    }
  }
}
?>