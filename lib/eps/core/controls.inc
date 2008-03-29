<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (LIB_DIR . "utils/smarty/Smarty.class.php");
$_f_c_registry = array ();
$_f_c_path_common = NULL;
$_f_c_defs_common = array ();
$_f_c_path_service = NULL;
$_f_c_defs_service = array ();
function writeAttr(&$params, $attr) {
  foreach ($attr as $a) {
    $val = $params[$a];
    if ($val) {
      echo " $a=\"$val\"";
    }
  }
}
function register_resource($kind, &$id, &$res) {
  global $_f_c_registry;
  $_f_c_registry[$kind][$id] = $res;
}
function _getDefFromService(&$kind, &$id) {
  global $CONTEXT;
  global $CONFIG;
  global $_f_c_path_service;
  global $_f_c_defs_service;
  $data = $_f_c_defs_service[$kind];
  if ($data == NULL) {
    if ($_f_c_path_service == NULL) {
      $_f_c_path_service = SRV_DIR . $CONTEXT->service->namespace . "/" . $CONFIG["relpath_config"] . "/";
    }
    $file = $_f_c_path_service . $kind . ".ini";
    if (file_exists($file)) {
      $data = parse_ini_file($file, true);
    } else {
      $data = array ();
    }
    $_f_c_defs_service[$kind] = $data;
  }
  return $data[$id];
}
function _getDefFromCommon(&$kind, &$id) {
  global $CONFIG;
  global $_f_c_path_common;
  global $_f_c_defs_common;
  $data = $_f_c_defs_common[$kind];
  if ($data == NULL) {
    if ($_f_c_path_common == NULL) {
      $_f_c_path_common = "./" . $CONFIG["relpath_config"] . "/";
    }
    $file = $_f_c_path_common . $kind . ".ini";
    if (file_exists($file)) {
      $data = parse_ini_file($file, true);
    } else {
      $data = array ();
    }
    $_f_c_defs_common[$kind] = $data;
  }
  return $data[$id];
}
function getResourceById($kind, &$id) {
  global $_f_c_registry;
  $res = $_f_c_registry[$kind][$id];
  if ($res == NULL) {
    $def = _getDefFromService($kind, $id);
    if (!$def) {
      $def = _getDefFromCommon($kind, $id);
    }
    if ($def) {
      $res = new $kind ($def);
      register_resource($kind, $id, $res);
    }
  }
  return $res;
}
class TControl {
  function isCompatible(&$handset) {
    return TRUE;
  }
  function build(&$info) {
    foreach ($info as $nam => $val) {
      $this-> $nam = $val;
    }
  }
}
class TImage extends TControl {
  var $style;
  var $alt_text;
  var $url;
  var $mime_type;
  var $width;
  var $height;
  var $colors;
  var $size;
  function TImage(&$info) {
    $this->build($info);
  }
}
class TIcon extends TControl {
  var $images;
  var $alt_text;
  function TIcon(&$info) {
    $this->build($info);
    $this->images = explode(" ", $this->images);
  }
}
class TLink extends TControl {
  var $style;
  var $caption;
  var $url;
  var $icon;
  var $access_key;
  function TLink(&$info) {
    $this->build($info);
  }
}
class TPage {
  var $_confcache;
  var $_template;
  var $_title = "noname";
  var $_name = "generic";
  var $_cacheKey;
  var $_objects;
  var $clientCachePolicy;
  var $proxyCachePolicy;
  var $serverCachePolicy;
  function TPage(&$res) {
    global $HANDSET;
    $this->clientCachePolicy = 86400;
    $this->proxyCachePolicy = 0;
    $this->serverCachePolicy = 604800;
    $this->_cacheKey[] = $HANDSET->ID;
    if ($res["title"]) {
      $this->_title = $res["title"];
    }
    if ($res["template"]) {
      $this->_template = $res["template"];
      $this->_cacheKey[] = $this->_template;
    }
  }
  function setup(&$cached) {
  }
  function loadConf($path) {
    global $SERVICE;
    $path = $SERVICE->findData($path);
    $conf = $this->_confcache[$path];
    if (!$conf) {
      $conf = parse_ini_file($path, true);
      $this->conf[$path] = $conf;
    }
    return $conf;
  }
  function saveExitPoint($url = NULL, $cap = NULL, $icon = NULL) {
    global $CONTEXT;
    $CONTEXT->portalMetadata->exit_url = $url;
    $CONTEXT->portalMetadata->exit_caption = $cap;
    $CONTEXT->portalMetadata->exit_icon = $icon;
    $CONTEXT->portalMetadata->store();
  }
  function registerChannelLink($exitPoint = false) {
    global $CONTEXT;
    global $SERVICE;
    $url = $CONTEXT->portalMetadata->exit_url;
    $cap = $CONTEXT->portalMetadata->exit_caption;
    $icon = $CONTEXT->portalMetadata->exit_icon;
    if ($url || $exitPoint) {
      // Exit point
      $def['url'] = $url;
      if ($icon) {
        $def['icon'] = $icon;
      }
      $def['caption'] = $cap;
      $this->register_link("channel", new TLink($def));
    } else {
      // Parent Servizio
      $serviceID = $SERVICE->serviceID . "_parent";
      $res = &getResourceById("TLink", $serviceID);
      $this->register_link("channel", $res);
    }
  }
  function getStyleSheetURL() {
    global $SERVICE;
    return array (
      "" => "style.php?s=" . $SERVICE->namespace,
      "handheld" => "style.php?s=" . $SERVICE->namespace
    );
  }
  function getFooterLinks() {
    return NULL;
  }
  function getName() {
    return $this->_name;
  }
  function getTemplate() {
    return $this->_template;
  }
  function getTitle() {
    return $this->_title;
  }
  function getCacheID() {
    if ($this->_cacheKey) {
      $cacheID = NULL;
      foreach ($this->_cacheKey as $key) {
        if ($cacheID) {
          $cacheID .= " $key";
        } else {
          $cacheID = $key;
        }
      }
      return $cacheID;
    } else {
      return null;
    }
  }
  function getClientCachePolicy() {
    return $this->clientCachePolicy;
  }
  function getProxyCachePolicy() {
    return $this->proxyCachePolicy;
  }
  function getServerCachePolicy() {
    return $this->serverCachePolicy;
  }
  function register_icon($id, &$res) {
    register_resource("TIcon", $id, $res);
  }
  function register_image($id, &$res) {
    register_resource("TImage", $id, $res);
  }
  function register_link($id, &$res) {
    register_resource("TLink", $id, $res);
  }
}
class TRender {
  var $smarty;
  var $template;
  var $cacheID;
  function TRender() {
  }
  function getCacheTemplateDir() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $subdir = $CONTEXT->renderClass;
    return $CONFIG["path_cache_srv"] . "templates" . DIR_SEP. $subdir;
  }
  function getCachePageDir() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $subdir = $CONTEXT->renderClass;
    return $CONFIG["path_cache_srv"] . "pages" . DIR_SEP. $subdir;
  }
  function getTemplateDir() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $subdir = $CONTEXT->renderClass;
    $base1 = SRV_DIR . $SERVICE->namespace . DIR_SEP . $CONFIG["relpath_template"];
    $base2 = "." . DIR_SEP . $CONFIG["relpath_template"];
    $dirs = array (
      $base2 . DIR_SEP . $SERVICE->namespace . DIR_SEP . $subdir,
      $base2 . DIR_SEP . $SERVICE->namespace,
      $base1 . DIR_SEP . $subdir,
      $base1,
      $base2 . DIR_SEP . $subdir,
      $base2
    );
    return $dirs;
  }
  function writeHTTPHeader() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    Header("Content-type: " . $HANDSET->getContentType());
    $cache = $PAGE->getClientCachePolicy();
    switch ($cache) {
      case -2 :
        {
          Header("Cache-Control: no-cache, must-revalidate");
          Header("Pragma: no-cache");
          break;
        }
      case -1 :
        {
          Header("Cache-Control: no-cache");
          Header("Pragma: no-cache");
          break;
        }
      case 0 :
        {
          break;
        }
      default :
        {
          Header("Cache-Control: max-age=$cache");
          break;
        }
    }
  }
  function getSmarty() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $rc = $CONTEXT->renderClass;
    $path = EPS_CORE_DIR . "plugins/" . $rc;
    $smarty = new Smarty;
    $smarty->plugins_dir = array (
      "plugins",
      $path,
      EPS_CORE_DIR . "plugins"
    );
    $smarty->compile_dir = $this->getCacheTemplateDir();
    $smarty->cache_dir = $this->getCachePageDir();
    $smarty->template_dir = $this->getTemplateDir();
    $smarty->config_dir = $SERVICE->getConfigDir();
    $smarty->compile_id = $SERVICE->serviceID;
    return $smarty;
  }
  function process() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $this->smarty = $this->getSmarty();
    if (ALLOW_CACHE) {
      $this->cacheID = $PAGE->getCacheID();
      $ttl = $PAGE->getServerCachePolicy();
      if ($ttl > 0) {
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = $ttl;
      }
    }
    else {
      $this->cacheID = null;
      $this->smarty->caching = false;
    }
    $this->template = $PAGE->getTemplate() . ".tpl";
    if ($this->cacheID != NULL) {
      $cached = $this->smarty->is_cached($this->template, $this->cacheID);
    }
    else {
      $cached = false;
    }
    $PAGE->setup($cached);
    $PAGE->registerChannelLink(false);
    $this->writeHTTPHeader();
    $this->smarty->assign("page", $PAGE);
    if ($PAGE->_objects) {
      foreach ($PAGE->_objects as $nam => $val) {
        $this->smarty->assign($nam, $PAGE-> $val);
      }
    }
    $this->smarty->assign("handset", $HANDSET);
    $this->smarty->load_filter("output", "trimwhitespace");
    if ($this->cacheID == NULL) {
      $this->smarty->display($this->template);
    }
    else {
      $this->smarty->display($this->template, $this->cacheID);
    }
  }
}
?>