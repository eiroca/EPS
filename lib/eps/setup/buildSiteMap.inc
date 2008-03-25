<?

function writeSiteMapCategory($f, &$server, &$portal, &$link, $category) {
  $menu = $portal[$category]["menu"];
  $title = @$portal[$category]["description"];
  $id = substr($category, 9);
  fwrite($f, "<url>");
  if ($title != null) {
    if (SITEMAP_EXTENDED) {
      fwrite($f, "<title>".$title."</title>");
    }
    else {
      fwrite($f, "<!-- ".$title." -->");
    }
  }
  fwrite($f, "<loc>".$server."?a=CAT&amp;i=".$id."</loc>");
  fwrite($f, "</url>");
  $list = explode(" ", $menu);
  foreach ($list as $item) {
    $nam = $item;
    if (strpos($nam, "category_") === 0) {
      writeSiteMapCategory($f, $server, &$portal, &$link, $nam);
    }
    else {
      $l = @$link[$nam];
      if ($l != null) {
        fwrite($f, "<url>");
        $title = $l["caption"];
        $url = $l["url"];
        if ($url {0} == "#") {
          $ps = strpos($url, "#", 1);
          $what = substr($url, 1, $ps - 1);
          $parm = substr($url, $ps + 1);
          $url = $server . $parm;
        }
        if ($title != null) {
          if (SITEMAP_EXTENDED) {
            fwrite($f, "<title>".$title."</title>");
          }
          else {
            fwrite($f, "<!-- ".$title." -->");
          }
        }
        fwrite($f, "<loc>".$url."</loc>");
        fwrite($f, "</url>");
      }
    }
  }
}

function buildSiteMapMobile($server, $dir, &$CONFIG, $fname) {
  $link   = parse_ini_file($dir . $CONFIG["relpath_config"] . DIR_SEP . "TLink.ini", true);
  $portal =  parse_ini_file($dir . $CONFIG["relpath_config"] . DIR_SEP . "HP". DIR_SEP . "portal.ini", true);
  $f = fopen($fname, "w+");
  fwrite($f, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
  fwrite($f, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");
  writeSiteMapCategory($f, $server, $portal, $link, "category_0");
  fwrite($f, "</urlset>\n");
  fclose($f);
 }

?>