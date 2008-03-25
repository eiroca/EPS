<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
  $CONFIG["file_indexfile"] = "index.ini";
  $CONFIG["file_accesslog"] = "access.log";
  $CONFIG["file_errorlog"]  = "error.log";

  $CONFIG["path_indexfile"] = "./data/";
  $CONFIG["path_log"]       = "./logs/";
  $CONFIG["path_static"]    = "./static/";

  $CONFIG["path_banner"]    = "./banners/";
  $CONFIG["path_user"]      = "./users/";

  $CONFIG["user_auth"]  = "simple";
  $CONFIG["page_login"] = "index.php?page=ADMIN_LOGIN";

  $MESSAGES["last_modify"]  = "Last Update: ";
  $MESSAGES["version"]      = "Version: ";
?>