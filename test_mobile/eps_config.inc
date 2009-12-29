<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
if (!defined(ALLOW_CACHE))    { define(ALLOW_CACHE, false); }
if (!defined('REDIR_PATH'))   { define('REDIR_PATH',   "index.php"); }
if (!defined('YADS_DIR'))     { define('YADS_DIR',     dirname(__FILE__).DIR_SEP);}
if (!defined('YADS_LOGPATH')) { define('YADS_LOGPATH', YADS_DIR."var".DIR_SEP."logs".DIR_SEP."download_%s.log");}
if (!defined('YADS_INDEX'))   { define('YADS_INDEX',   YADS_DIR."var".DIR_SEP."data".DIR_SEP);}
if (!defined('YADS_DATA'))    { define('YADS_DATA',    YADS_DIR."download");}
if (!defined('YADS_URL'))     { define('YADS_URL',     "http://" . $_SERVER["SERVER_NAME"] . "/test_mobile/download.php");}

$CONFIG["mobile"] = true;
$CONFIG["secret"] = "ecsb";
$CONFIG["ADS"] = true;
$CONFIG["server_path"] = "/mobile/";
$CONFIG["server_fullpath"] = "http://www.eiroca.net/mobile/index.php";
$CONFIG["homepage"] = "index.php";
$CONFIG["file_accesslog"] = "access_%s.log";
$CONFIG["file_errorlog"]  = "error.log";
$CONFIG["path_banner"]      = "./banners/";
$CONFIG["path_log"]         = "./var/logs/";
$CONFIG["path_counters"]    = "./var/counters/";
$CONFIG["path_data"]        = "./var/data/";
$CONFIG["path_cache_srv"]   = "./var/data/";
$CONFIG["path_cache_eps"]   = "./var/eps/";
$CONFIG["path_dynamic"]     = "./var/";
$CONFIG["path_user"]        = "./var/users/";
$CONFIG["relpath_template"] = "templates";
$CONFIG["relpath_config"]   = "data";
$CONFIG["user_auth"] = "simple";
$CONFIG["page_login"] = "service.php?s=USR";

?>
