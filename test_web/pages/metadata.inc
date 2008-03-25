<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
global $DATA;
$DATA["title"] = "eIrOcA";
$DATA["message"] = "best viewed 800x600";
$DATA["last_modify"]="1 Mar 2999";
$DATA["copyright_url"] = "index.php";
$DATA["copyright_caption"] = "Copyright (c) 2002-2008";
$DATA["sitemap_allow"] = true;
$DATA["sitemap_priority"] = 0.5;
global $MENU;
$MENU = array (
  array (
    "caption" => "PHP",
    "url" => "index.php?page=PHP",
    "icon"  => "./static/minilogo.gif"
  )
);
?>