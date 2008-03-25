<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class Page extends TPage {
  function Page(&$res) {
    parent::TPage($res);
    global $_REQUEST;
    $from = trim($_REQUEST["from"]);
    if (!$from) {
      $from = "anonimo";
    }
    $sugg = trim($_REQUEST["sugg"]);
    if ($sugg) {
      if ($this->writeSugg($from, $sugg)) {
        $this->result = 2;
      } else {
        $this->result = 0;
      }
    } else {
      $this->result = 1;
    }
  }
  function getTemplate() {
    return "suggerimenti";
  }
  function getClientCachePolicy() {
    return -1;
  }
  function getServerCachePolicy() {
    return -1;
  }
  function writeSugg(&$from, &$sugg) {
    global $CONFIG;
    $path = $CONFIG["path_data"] . "suggerimenti.txt";
    $sugg = ereg_replace("\t", " ", $sugg);
    $sugg = ereg_replace("\n", " ", $sugg);
    $sugg = ereg_replace("\r", " ", $sugg);
    $f = fopen($path, "a+");
    if ($f) {
      $res = fwrite($f, $from . "\t" . $sugg . "\n");
      fclose($f);
      if ($res) {
        return true;
      }
    }
    return false;
  }
  function getTitle() {
    return "eIrOcA";
  }
  function getName() {
    return "EIROCA Service";
  }
}
?>
