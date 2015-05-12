<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
class Service_PG extends TService {

	function Service_PG() {
		$this->namespace = 'PG';
		$this->default_action = 'START';
		$this->default_page = 'MAIN';
	}
}
?>
