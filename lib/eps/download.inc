<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
function read_char(&$f) {
  $c = fgetc($f);
  if ($c == "\r") {
    $c = "\n";
  }
  return $c;
}
function read_line(&$f) {
  $line = "";
  while (!feof($f)) {
    $c = read_char($f);
    if ($c == "\n") {
      if ($line != "") {
        break;
      }
    } else {
      $line = $line . $c;
    }
  }
  return $line . "\n";
}
function process_jad($id, &$fn) {
  $f = fopen($fn, "r");
  $empty = false;
  $out = "";
  while (!feof($f)) {
    $l = read_line($f);
    if ($l == "") {
      if ($empty) {
        break;
      } else {
        $empty = true;
      }
    } else {
      $empty = false;
      if (strncasecmp($l, "MIDlet-Jar-URL", 14) === 0) {
        $l = "MIDlet-Jar-URL: " . YADS_URL . "?n=$id&t=jar\n";
        $l .= "MIDlet-Install-Notify: " . YADS_URL . "?n=$id&a=NI\n";
        $l .= "MIDlet-Delete-Notify: " . YADS_URL . "?n=$id&a=ND\n";
      }
      elseif (strncasecmp($l, "MIDlet-Install-Notify", 21) === 0) {
        $l = "";
      }
      elseif (strncasecmp($l, "MIDlet-Delete-Notify", 20) === 0) {
        $l = "";
      }
      if ($l != "") {
        $out = $out . $l;
      }
    }
  }
  fclose($f);
  $size = strlen($out);
  header("Content-Description: eIrOcA download");
  header("Content-Disposition: attachment; filename=" . basename($fn));
  Header("Content-Type: text/vnd.sun.j2me.app-descriptor");
  Header("Content-Length: " . $size);
  echo $out;
  return $size;
}
function process_cer($id, &$fn) {
  $size = filesize($fn);
  $bn = basename($fn);
  header('Content-Description: eIrOcA Certificate');
  header('Content-Type: application/x-x509-ca-cert');
  header("Content-Disposition: attachement; filename=$bn");
  header("Content-Length: $size");
  $c = file_get_contents($fn);
  echo $c;
  return $size;
}
function process_jar(&$fn) {
  $size = filesize($fn);
  header("Content-Description: eIrOcA download");
  header("Content-Disposition: attachment; filename=" . basename($fn));
  header("Content-Type: application/java-archive");
  header("Content-Length: $size");
  $c = file_get_contents($fn);
  echo $c;
  return $size;
}
function process_notify(&$fn) {
  $statusCode = file_get_contents("php://input");
  global $status;
  $status = urlencode(trim($statusCode));
  return strlen($status);
}
function decodeRequest() {
  global $_REQUEST;
  global $_SERVER;
  global $agent;
  global $id;
  global $file;
  global $type;
  global $action;
  global $sessionName;
  global $status;
  global $category;
  $agent = $_SERVER["HTTP_USER_AGENT"];
  $id = urlencode($_REQUEST["n"]);
  $file = urlencode($_REQUEST["f"]);
  $type = urlencode($_REQUEST["t"]);
  $action = urlencode($_REQUEST["a"]);
  $sessionName = urlencode($_REQUEST["s"]);
  $category = urlencode($_REQUEST["c"]);
  $status = 200;
  $defAct = "D";
  if ($id == "") {
    $id = "default";
  }
  if ($type == "") {
    $type = "jad";
    $defAct = "I";
  }
  if ($action == "") {
    $action = $defAct;
  }
  if ($sessionName == "") {
    $sessionName = "SID";
  }
  if ($category == "") {
   $category = "000";
  }
}
function check_metadata($index, $category) {
  if (!file_exists($index)) {
    include EPS_DIR . "setup" . DIR_SEP . "buildIndex.inc";
    buildIndex($index, YADS_DATA . DIR_SEP. $category, array(".jad"));
  }
}
function load_metadata() {
  global $_REQUEST;
  global $_SERVER;
  global $agent;
  global $id;
  global $type;
  global $action;
  global $sessionName;
  global $status;
  global $category;
  $index = YADS_INDEX . "download_$category.ini";
  check_metadata($index, $category);
  return parse_ini_file($index, true);
}
function serveRequest() {
  global $agent;
  global $id;
  global $file;
  global $type;
  global $action;
  global $sessionName;
  global $status;
  global $configuration;
  global $resource;
  global $SID;
  global $SIZE;
  if ($file){
    $resource = YADS_DATA . DIR_SEP . $file;
  }
  else {
    $res = "file_$id";
    $resource = $configuration[$res]["path"] . $configuration[$res]["basename"];
    if ($resource != "") {
      $resource = $resource . "." . $type;
    }
  }
  session_name($sessionName);
  session_start();
  $SID = session_id();
  $SIZE = 0;
  if (!file_exists($resource)) {
    $status = 500;
    header("Location: " . REDIR_PATH);
  }
  else if ($action == "I") {
    $SIZE = process_jad($id, $resource);
  }
  else if ($action == "C") {
    $SIZE = process_cer($id, $resource);
  }
  else if ($action == "D") {
    $SIZE = process_jar($resource);
  }
  else if ($action == "NI") {
    $SIZE = process_notify($resource);
  }
  else if ($action == "ND") {
    $SIZE = process_notify($resource);
  }
}
function logRequest() {
  global $agent;
  global $id;
  global $type;
  global $action;
  global $sessionName;
  global $status;
  global $resource;
  global $SID;
  global $SIZE;
  $remote = $_SERVER["REMOTE_ADDR"];
  $gmt = date("d/M/Y:H:i:s", time());
  $today = date("YMd", time());
  $log_filename = sprintf(YADS_LOGPATH, $today);
  $f = fopen($log_filename, "a+");
  fputs($f, "$gmt\t$action\t$id\t$resource\t$status\t$SIZE\t$remote\t$SID\t$agent\n");
  fclose($f);
}
?>
