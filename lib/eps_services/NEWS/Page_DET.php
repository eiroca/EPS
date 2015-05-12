<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
class Page extends TPage {
	var $nid;
	var $links;
	var $det;
	var $url;

	function Page(&$res) {
		parent::TPage($res);
		$this->nid = 'news_' . $this->getRequestVar('i', '0');
		$this->_cacheKey[] = $this->nid;
	}

	function setup(&$cached) {
		if (!$cached) {
			parent::setup($cached);
			$conf = $this->loadConf('news.ini');
			$this->det = $conf[$this->nid];
			$this->links = explode(' ', $conf[$this->nid]['service']);
		}
	}

	function getTemplate() {
		return 'show';
	}

	function getName() {
		return 'News Service';
	}

	function getTitle() {
		return 'News';
	}

	function getFooterLinks() {
		return array (
				'back' => 'NEWS_home' 
		);
	}
}
?>