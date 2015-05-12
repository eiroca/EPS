<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
class HPPage extends TPage {
	var $language;
	var $baseurl;

	function HPPage(&$res) {
		parent::TPage($res);
		global $CONTEXT;
		global $CONFIG;
		if (isset($CONTEXT->language)) {
			$this->language = $CONTEXT->language;
			$this->_cacheKey[] = $this->language;
		}
		$this->baseurl = $CONFIG['URL_portal'] . '?a=CAT&amp;i=';
	}

	function registerBack($id) {
		$def = $this->conf[$id];
		$back = $def['back'];
		if ($back) {
			$link = &getResourceById('TLink', $back);
			if (!$link) {
				$lnk['caption'] = 'Indietro';
				$lnk['icon'] = 'system_pin';
				if (strpos($back, 'category_') === 0) {
					$i = strtok($back, '_');
					$i = strtok('_');
					$lnk['url'] = $this->baseurl . $i;
					$link = new TLink($lnk);
				}
			}
			if ($link) {
				$this->register_link('back', $link);
			}
		}
	}

	function setProperties(&$def, $prop) {
		foreach ($prop as $p) {
			if (isset($def[$p])) {
				$this->$p = $def[$p];
			}
		}
	}

	function readCategory(&$cat, $id) {
		$def = $this->conf[$id];
		$this->readMenu($cat->menu, $def['menu'], $id);
		$this->setProperties($def, array (
				'description', 'caption', 'icon', 'clientCachePolicy', 'proxyCachePolicy', 'serverCachePolicy', 'message' 
		));
	}

	function readMenu(&$list, &$menu, $id) {
		$list = explode(' ', $menu);
		foreach ($list as $item) {
			$nam = $item;
			if (strpos($nam, 'category_') === 0) {
				$def = $this->conf[$nam];
				$this->buildLink($nam, $def, $nam);
			}
		}
	}

	function buildLink($nam, &$def, $item) {
		if (!isset($def['url'])) {
			$i = strtok($item, '_');
			$i = strtok('_');
			$def['url'] = $this->baseurl . $i;
		}
		$this->register_link($nam, new TLink($def));
	}

	function loadPortal() {
		$name = 'portal.ini';
		$this->conf = $this->loadConf($name);
	}

	function getTitle() {
		return $this->conf[$this->cid]['caption'];
	}
}
?>