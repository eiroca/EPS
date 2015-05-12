<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . 'AFO' . DIR_SEP . 'AFOPage.php');

class Page extends AFOPage {
	var $iid;
	var $cid;
	var $caption;
	var $aforismo;
	var $afo;

	function Page(&$res) {
		parent::AFOPage($res);
		$this->cid = $this->getRequestVar('c');
		$this->iid = $this->getRequestVar('i');
		if (!$this->iid) {
			$this->loadAfo();
			$count = (int)$this->afo['main']['count'];
			$this->iid = rand(1, $count);
		}
		$this->_cacheKey[] = $this->cid;
		$this->_cacheKey[] = $this->iid;
	}

	function loadAfo() {
		global $CONFIG;
		global $SERVICE;
		if (!$this->afo) {
			$cat = 'category_' . $this->cid;
			$path = $SERVICE->findData($this->conf[$cat]['path']);
			$this->afo = parse_ini_file($path, true);
		}
	}

	function setup(&$cached) {
		if (!$cached) {
			$this->loadAfo();
			$count = (int)$this->afo['main']['count'];
			$this->caption = $this->afo['main']['caption'];
			do {
				if (!$this->iid) {
					$this->iid = rand(1, $count);
				}
				$id = 'aforisma_' . $this->iid;
				if (isset($this->afo[$id])) {
					$this->aforisma = $this->afo[$id];
					$desc = $this->afo[$id]['description'];
				}
				else {
					$this->iid = NULL;
				}
			}
			while ($this->iid == NULL);
			$iid = $this->iid + 1;
			if ($iid > $count) {
				$iid = 1;
			}
			$this->register_link('AFO_next', new TLink(sprintf("vai a %s di %s", $iid, $count), sprintf("#service#?s=AFO&amp;a=SHOW&amp;t=%s&amp;c=%s&amp;i=%s", $this->kind_id, $this->cid, $iid)));
			$this->register_link('AFO_random', new TLink($this->afo['main']['label1'], sprintf("#service#?s=AFO&amp;a=SHOW&amp;t=%s&amp;c=%s", $this->kind_id, $this->cid)));
			$this->register_link('AFO_elenco', new TLink('vai a...', sprintf('#service#?s=AFO&amp;a=GOTO&amp;t=%s&amp;c=%s', $this->kind_id, $this->cid), 'system_dot3'));
		}
	}

	function getClientCachePolicy() {
		global $CONTEXT;
		if ($CONTEXT->getRequestVAR('i')) {
			return 86400;
		}
		else {
			return -2;
		}
	}

	function getTemplate() {
		return 'show';
	}

	function getFooterLinks() {
		return array (
				'AFO_elenco', 
				'AFO_home' 
		);
	}
}
?>
