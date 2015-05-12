<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . 'RSS' . DIR_SEP . 'RSSPage.php');

class Page extends RSSPage {
	var $nid;
	var $det;

	function Page(&$res) {
		parent::RSSPage($res);
		$this->nid = 'news_' . $this->getRequestVar('i', '');
		$this->_cacheKey[] = $this->nid;
	}

	function setup(&$cached) {
		if (!$cached) {
			parent::setup($cached);
			$def['caption'] = $this->rss->channel['title'];
			$def['url'] = '#service#?s=RSS&amp;r=' . $this->rid;
			$this->register_link('rss_home', new TLink($def));
			unset($def);
			$def['caption'] = 'qui';
			$def['url'] = $this->rss->channel['link'];
			$this->register_link('rss_link', new TLink($def));
			unset($def);
			if (isset($this->rss->image['url'])) {
				$img = $this->rss->image['url'];
				$def['alt_text'] = ' ';
				$def['url'] = $img;
				$info = pathinfo($img);
				$def['format'] = $info['extension'];
				$this->register_image('_IMG', new TImage($def));
				unset($def);
			}
			$def['images'] = '_IMG';
			$def['alt_text'] = ' ';
			$this->register_icon('rss_icon', new TIcon($def));
		}
	}

	function getTemplate() {
		return 'info';
	}

	function getFooterLinks() {
		return array (
				'back' => 'rss_home' 
		);
	}
}
?>