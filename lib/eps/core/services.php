<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
class TAction {
	var $_stateless = true;

	function execute() {
		return array ();
	}
}

class TService {
	var $namespace;
	var $actionID;
	var $pageID;
	var $securityRole;

	function getConfigDir() {
		global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
		$dirs = array (
				'.' . DIR_SEP . $CONFIG['relpath_config'] . DIR_SEP . $this->namespace, SRV_DIR . $CONFIG['relpath_config'] . DIR_SEP . $this->namespace 
		);
		return $dirs;
	}

	function findData($name) {
		$_ok = false;
		foreach ((array)$this->getConfigDir() as $_curr_path) {
			$path = $_curr_path . DIR_SEP . $name;
			if (file_exists($path)) {
				$_ok = true;
				break;
			}
		}
		if (!$_ok) {return NULL;}
		return $path;
	}

	function execute() {
		global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE, $USER;
		if ($this->securityRole != NULL) {
			initUser();
			$USER->forceLogged($this->securityRole);
		}
		$this->actionID = urlencode($CONTEXT->getRequestVAR(KEY_ACTION));
		if (!file_exists(SRV_DIR . $SERVICE->serviceID . '/Action_' . $this->actionID . '.php')) {
			$this->actionID = $this->default_action;
		}
		require_once (SRV_DIR . $SERVICE->serviceID . '/Action_' . $this->actionID . '.php');
		$action = new Action();
		$res = $action->execute();
		if (isset($res['action'])) {
			$action = $res['action'];
			$this->$action($res);
		}
		else {
			$this->render($res);
		}
	}

	function nop(& $res) {
	}

	function redirect(& $res) {
		header('Location: ' . $res['URL']);
	}

	function render(&$res) {
		global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE, $RENDER;
		require_once (EPS_CORE_DIR . 'controls.php');
		$this->pageID = $res['page'];
		if ($this->pageID == '*') {
			$PAGE = new TPage($res);
		}
		else {
			if (!file_exists(SRV_DIR . $this->serviceID . '/Page_' . $this->pageID . '.php')) {
				$this->pageID = $this->default_page;
			}
			require_once (SRV_DIR . $this->serviceID . '/Page_' . $this->pageID . '.php');
			$PAGE = new Page($res);
		}
		$RENDER = new TRender();
		$RENDER->process();
	}
}
?>