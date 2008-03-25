<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class THandset {
  var $handsetType = NULL;
  var $xhtml_ui_xhtml_honors_table_bgcolor = true;
  var $xhtml_ui_xhtml_honors_table_nbsp = true;
  function THandset($def = NULL) {
    if ($def != null) {
      include($def);
    }
  }
  function getHandsetType() {
    if ($this->handsetType === NULL) {
      $mode["wml_1_1"] = 0;
      $mode["wml_1_2"] = 0;
      $mode["wml_1_3"] = 0;
      $mode["html_web_3_2"] = 3.01;
      $mode["html_web_4_0"] = 3.02;
      $mode["html_wi_w3_xhtmlbasic"] = 1.01;
      $mode["html_wi_oma_xhtmlmp_1_0"] = 1.02;
      $mode["html_wi_imode_html_1"] = 2.01;
      $mode["wi_imode_html_2"] = 2.02;
      $mode["html_wi_imode_html_3"] = 2.03;
      $mode["html_wi_imode_html_4"] = 2.04;
      $mode["html_wi_imode_html_5"] = 2.05;
      $mode["html_wi_imode_htmlx_1"] = 2.06;
      $mode["html_wi_imode_compact_generic"] = 2.07;
      $m = $mode[$this->markup_preferred_markup];
      if ($m == null) {
        $m = 3.01;
      }
      $this->handsetType = $m;
    }
    return $this->handsetType;
  }
  function TAG($data) {
    $c = (int) $this->getHandsetType();
    if ($c == 2) {
      return "<$data>";
    } else {
      return "<$data/>";
    }
  }
  function BR() {
    $c = (int) $this->getHandsetType();
    if ($c == 2) {
      return "<br>";
    } else {
      return "<br/>";
    }
  }
  function getContentType() {
    $c = $this->getHandsetType();
    if ($c == 1.01)
      return "application/xhtml+xml";
    if ($c == 1.02)
      return "application/vnd.wap.xhtml+xml";
    if ((int) $c == 2)
      return "text/html";
    if ((int) $c == 3)
      return "text/html";
    return "text/vnd.wap.wml";
  }
  function getDocType() {
    $c = $this->getHandsetType();
    if ((int) $c == 0)
      return "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">";
    if ($c == 1.02)
      return "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
    return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
  }
  function isUnknown() {
    return !($this->product_info_brand_name & $this->product_info_model_name);
  }
}
function loadHandset($ua = NULL) {
  global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
  if ($ua === NULL) {
    global $_SERVER;
    $ua = $_SERVER["HTTP_USER_AGENT"];
  }
  $crc = abs(crc32($ua));
  $dir = $crc & 255;
  $fulldir = $CONFIG["path_cache_eps"] . "devices/" . $dir;
  if (!is_dir($fulldir)) {
    mkdir($fulldir);
  }
  $path = $fulldir . "/" . $crc . ".obj";
  $handset = null;
  if (file_exists($path)) {
    $fd = fopen($path, "r");
    $d = fread($fd, filesize($path));
    fclose($fd);
    $handset = unserialize($d);
    if ($handset->ua != $ua) {
      $handset = null;
    }
  }
  if ($handset == null) {
    require_once (EPS_CORE_DIR . "handset_load.inc");
    $handset = _getHandsetInRegistry($ua);
    $handset->ua = $ua;
    $fd = fopen($path, "w+");
    $d = fwrite($fd, serialize($handset));
    fclose($fd);
  }
  return $handset;
}
?>