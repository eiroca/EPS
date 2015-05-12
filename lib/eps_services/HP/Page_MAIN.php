<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR . 'AFO' . DIR_SEP . 'Service.php');
require_once (SRV_DIR . 'HP' . DIR_SEP . 'HPPage.php');

class Page extends HPPage {
	var $news;
	var $welcome;
	var $categories;
	var $links;
	var $afo_des;
	var $afo_aut;
	var $conf;

	function Page(&$res) {
		parent::HPPage($res);
		$this->saveExitPoint(NULL);
		$this->cid = 'category_0';
		$this->clientCachePolicy = 28800;
		$this->serverCachePolicy = 21600;
		$this->proxyCachePolicy = 21600;
	}

	function setup(&$cached) {
		if (!$cached) {
			global $CONTEXT;
			$this->loadPortal();
			$this->readCategory($this, $this->cid);
			$afo = new Service_AFO();
			list ($this->afo_des, $this->afo_aut) = $afo->getAforismoRandom();
		}
	}

	function getTemplate() {
		return 'homepage';
	}
}
?>
