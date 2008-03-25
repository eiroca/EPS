<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
function writeSiteMapAtr(&$f, $atr) {
  global $DATA;
  global $MENU;
  $val = @$DATA["sitemap_$atr"];
  if ($val) {
    fwrite($f, "<$atr>$val</$atr>");
  }
}

function writeSiteMapURL(&$f, &$server, &$basepath, $pathdata, $name, $parent) {
  global $DATA;
  global $MENU;
  $dir = opendir($basepath . $pathdata);
  $metaPath = $basepath . $pathdata . "/metadata.inc";
  $valid = file_exists($metaPath);
  if ($valid) {
    include ($metaPath);
    $export = @$DATA["sitemap_allow"];
    if ($export == true) {
      fwrite($f, "<url>");
      if (SITEMAP_EXTENDED) {
        fwrite($f, "<title>".$DATA["title"]."</title>");
      }
      else {
        fwrite($f, "<!-- ".$DATA["title"]." -->");
      }
      fwrite($f, "<loc>".$server.($name?"?page=".$name:"")."</loc>");
      writeSiteMapAtr(&$f, "priority");
      writeSiteMapAtr(&$f, "lastmod");
      writeSiteMapAtr(&$f, "changefreq");
      fwrite($f, "</url>\n");
    }
    $DATA=null;
    $MENU=null;
  }
  while (($file = readdir($dir)) !== false) {
    if (substr($file, 0, 1) != ".") {
      $fullpath = $pathdata . "/" . $file;
      if (is_dir($basepath . $fullpath)) {
        if ($name) {
          $newname = $name . "_" . $file;
        } else {
          $newname = $file;
        }
        writeSiteMapURL($f, $server, $basepath, $fullpath, $newname, $name);
      }
    }
  }
  closedir($dir);
}

function buildWebSiteMap($fname, $server, $basepath = "./", $path = "pages") {
  $f = fopen($fname, "w+");
  fwrite($f, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
  fwrite($f, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");
  writeSiteMapURL($f, $server, $basepath, $path, null, null);
  fwrite($f, "</urlset>\n");
  fclose($f);
}
?>