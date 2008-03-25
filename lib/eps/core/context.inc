<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (LIB_DIR . "/utils/smarty/internals/core.get_microtime.php");
define("KEY_SERVICE", "s");
define("KEY_ACTION", "a");
define("KEY_CLASS", "c");
define("KEY_DEF_SERVICE", "HP");
//define(HTTP_PROXY_HOST, "10.1.24.4");
//define(HTTP_PROXY_PORT, "8080");
define("ALLOW_CACHE", true);
class TContext {
  var $_begintime;
  function TContext() {
    $this->_begintime = smarty_core_get_microtime("", $this);
  }
  function redirect($url, $mode = NULL) {
    if ($mode != NULL) {
      header("Status: $mode Redirect");
    }
    header("Location: $url");
  }
  function decodeRenderClass() {
    global $HANDSET;
    $c = $HANDSET->getHandsetType();
    if ((int) $c == 0) {
      return "WML";
    }
    return "XHTML";
  }
  function decodeServiceID($serviceID = NULL, $defServiceID = NULL) {
    global $_REQUEST;
    global $CONFIG;
    if ($serviceID == NULL) {
      $serviceID = urlencode($_REQUEST[KEY_SERVICE]);
      if ($serviceID == NULL) {
        $serviceID = $defServiceID;
      }
    }
    return $serviceID;
  }
  function find(& $path, & $what) {
    foreach ($what as $file) {
      $full = $path . $file;
      if (file_exists($full)) {
        return $full;
      }
    }
    return null;
  }
  function logAccess($elapsed, $serviceID, $knd = "") {
    global $CONFIG;
    global $ADS;
    if ($ADS == null) {
      $ADS = "-";
    }
    $today = date("YMd", time());
    $log_filename = sprintf($CONFIG["path_log"].$CONFIG["file_accesslog"], $today);
    if ($log_filename != NULL) {
      global $HANDSET;
      global $_SERVER;
      if ($HANDSET != null) {
        $hid = $HANDSET->ID . "-" . $HANDSET->getHandsetType();
      }
      $remote = $_SERVER["REMOTE_ADDR"];
      $user = $_SERVER["PHP_AUTH_USER"];
      $query = $_SERVER["QUERY_STRING"];
      $path = $_SERVER["PATH_INFO"];
      if ($path == "") {
        $path = "/";
      }
      $gmt = date("d/M/Y:H:i:s", time());
      $referer = $_SERVER["HTTP_REFERER"];
      $agent = $_SERVER["HTTP_USER_AGENT"];
      $sid = session_id();
      $logline = sprintf("%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n", $gmt, $serviceID, $knd, (int) ($elapsed * 1000), $hid, $sid, $remote, $user, $query, $referer, $agent, $ADS);
      $f = fopen($log_filename, "a+");
      fputs($f, $logline);
      fclose($f);
    }
  }
  function touchCounter($name) {
    require_once (EPS_CORE_DIR . "context_utils.inc");
    _utils_touchCounter($name);
  }
  function errorTrace($msg) {
    require_once (EPS_CORE_DIR . "context_utils.inc");
    _utils_errorTrace($msg);
  }
  function processFilter($filter, $cond = null) {
    require_once (EPS_CORE_DIR . "context_filter.inc");
    if ($cond) {
      $prm = split(" ", $cond);
      $cmd = "_filter_" . $filter;
    } else {
      $prm = split(" ", $filter);
      $cmd = "_filter_" . array_shift($prm);
    }
    return $cmd ($prm);
  }
}
?>