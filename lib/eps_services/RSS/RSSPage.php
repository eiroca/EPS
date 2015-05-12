<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
define('MAGPIE_GETMODE', 1);
define('MAGPIE_CACHE_ON', true);
define('MAGPIE_CACHE_DIR', $CONFIG['path_cache_eps'] . DIR_SEP . 'services' . DIR_SEP . 'RSS');
global $CONFIG;
require_once (LIB_DIR . 'utils' . DIR_SEP . 'rss' . DIR_SEP . 'rss_fetch.inc');
require_once (LIB_DIR . 'utils' . DIR_SEP . 'rss' . DIR_SEP . 'rss_utils.inc');

class RSSPage extends TPage {
	var $rid;
	var $rss;
	var $conf;
	var $_default;

	function RSSPage(&$res) {
		parent::TPage($res);
		$this->rid = $this->getRequestVar('r');
		$this->_cacheKey[] = $this->rid;
		$tmp = $this->loadConf('index.ini');
		$this->conf = $tmp['rss_' . $this->rid];
		$this->_defautl = $tmp['main'];
	}

	function setup(&$cached) {
		if (!$cached) {
			parent::setup($cached);
			if ($this->conf) {
				define('MAGPIE_CACHE_AGE', $this->getCacheProp('cache-remote'));
				$this->loadRSS();
				$this->_objects['rss'] = 'rss';
			}
		}
	}

	function read_file($filename) {
		$fh = fopen($filename, 'r') or die('Errore irreversibile');
		$rss_string = fread($fh, filesize($filename));
		fclose($fh);
		return $rss_string;
	}

	function loadRSS() {
		global $CONTEXT;
		ob_start();
		$url = $this->conf['url'];
		$this->rss = fetch_rss($url);
		if (substr($url, 0, 4) == 'http') {
			$this->rss = fetch_rss($url);
		}
		else {
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
		return 'RSS Service';
	}

	function getTitle() {
		return $this->conf['caption'];
	}

	function getCacheProp($name) {
		if (isset($this->conf[$name])) {
			$val = $this->conf[$name];
		}
		else {
			$val = $this->_default[$name];
		}
		return $val;
	}

	function getClientCachePolicy() {
		return $this->getCacheProp('cache-client');
	}

	function getServerCachePolicy() {
		return $this->getCacheProp('cache-server');
	}
}
?>