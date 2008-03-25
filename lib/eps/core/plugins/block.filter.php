<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
function smarty_block_filter($params, $content, &$smarty) {
  global $CONTEXT;
  global $_smart_filter_visible;
  if ($_smart_filter_visible == NULL) {
    $_smart_filter_visible = array ();
  }
  if ($content == null) {
    foreach ($params as $filter => $val) {
      $v = $CONTEXT->processFilter($filter, $val);
      if ($v) {
        break;
      }
    }
    array_push($_smart_filter_visible, $v);
  } else {
    $v = array_pop($_smart_filter_visible);
    if ($v == true) {
      return $content;
    }
  }
}
?>