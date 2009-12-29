<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
define(MAGPIE_GETMODE, 1);
define(MAGPIE_CACHE_ON, true);
define(MAGPIE_CACHE_DIR, $CONFIG["path_cache_eps"].DIR_SEP."services".DIR_SEP."RSS");
global $CONFIG;
require_once (EPS_DIR."utils".DIR_SEP."rss".DIR_SEP."rss_fetch.inc");
require_once (EPS_DIR."utils".DIR_SEP."rss".DIR_SEP."rss_utils.inc");
class RSSPage extends TPage {
	var $rid;
	var $rss;
	var $conf;
	var $_default;
	function RSSPage(&$res) {
		parent::TPage($res);
		global $_REQUEST;
		$this->rid = $_REQUEST["r"];
		$this->_cacheKey[] = $this->rid;
		$tmp = $this->loadConf("index.ini");
		$this->conf = $tmp["rss_" . $this->rid];
		$this->_defautl = $tmp["main"];
	}
	function setup(&$cached) {
		if (!$cached) {
			parent::setup($cached);
			if ($this->conf) {
				define(MAGPIE_CACHE_AGE, $this->getCacheProp("cache-remote"));
				$this->loadRSS();
				$this->_objects["rss"] = "rss";
			}
		}
	}
	function read_file($filename) {
		$fh = fopen($filename, 'r') or die("Errore irreversibile");
		$rss_string = fread($fh, filesize($filename));
		fclose($fh);
		return $rss_string;
	}
	function loadRSS() {
		global $CONTEXT;
		ob_start();
		$url = $this->conf["url"];
		$this->rss = fetch_rss($url);
		if (substr($url, 0, 4) == "http") {
			$this->rss = fetch_rss($url);
		} else {
			$rss_string = $this->read_file($url);
			$this->rss = new MagpieRSS($rss_string);
		}
		$out = ob_get_contents();
		ob_end_clean();
		if ($out) {
			$CONTEXT->errorTrace($out);
		}
	}
	function getName() {
		return "RSS Service";
	}
	function getTitle() {
		return $this->conf["caption"];
	}
	function getCacheProp($name) {
		$val = $this->conf[$name];
		if ($val === NULL) {
			$val = $this->_default[$name];
		}
	}
	function getClientCachePolicy() {
		return $this->getCacheProp("cache-client");
	}
	function getServerCachePolicy() {
		return $this->getCacheProp("cache-server");
	}
}
?>