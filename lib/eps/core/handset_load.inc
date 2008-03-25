<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
function _getHandsetInRegistry($ua) {
  require_once (EPS_HANDSET_DIR . "handset_index.inc");
  foreach ($handset_index as $fileIndex) {
    $uaf = $fileIndex[0];
    if ($ua <= $uaf) {
      $fil = $fileIndex[1];
      break;
    }
  }
  include EPS_HANDSET_DIR . $fil;
  include EPS_HANDSET_DIR . "handset_reg_def.inc";
  global $handset_default_class;
  global $handset_default_path;
  global $handset_registry;
  $handset = null;
  foreach ($handset_registry as $handsetDef) {
    $sub = $handsetDef[0];
    if (!(strpos($ua, $sub) === false)) {
      $handset = $handsetDef[1];
      $path = $handsetDef[2];
      if ($path == null) {
        $path = $handset_default_path;
      }
      if ($handsetDef[3]) {
        break;
      }
    }
  }
  if ($handset == NULL) {
    global $handset_default_class;
    global $handset_default_path;
    $handset = $handset_default_class;
    $path = $handset_default_path;
  }
  if (1==0) {
    include EPS_HANDSET_DIR . $path;
    $result = new $handset;
  }
  else {
    $result = new THandset(EPS_HANDSET_DIR . $path);
  }
  return $result;
}
?>