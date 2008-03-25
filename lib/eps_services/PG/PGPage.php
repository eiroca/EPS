<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class PGPage extends TPage {
  var $conf;
  function PGPage(& $res) {
    parent::TPage($res);
    global $SERVICE;
    global $CONFIG;
    $conf_file = $CONFIG["path_cache_srv"] . DIR_SEP . $SERVICE->namespace . ".ini";
    if (!file_exists($conf_file)) {
      require_once (EPS_DIR . "setup" . DIR_SEP . "buildIndex.inc");
      $image_path = "." . DIR_SEP . $CONFIG["relpath_config"] . DIR_SEP . $SERVICE->namespace;
      buildIndex($conf_file, $image_path, array (
        ".jpg",
        ".jpeg"
      ));
    }
    $this->conf = parse_ini_file($conf_file, true);
  }
  function getName() {
    return "PG Service";
  }
  function getTitle() {
    return "Picture Gallery";
  }
}
?>