<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR."core".DIR_SEP."user.inc");
class TUser extends TAbstractUser {
	function die401() {
		header('WWW-Authenticate: Basic realm="eIrOcA"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Please log';
		exit;
	}
	function die403() {
		header('WWW-Authenticate: Basic realm="eIrOcA"');
		header('HTTP/1.0 403 Unauthorized');
		echo 'Invalid credientials';
		exit;
	}
	function getUserCredentials() {
		return array (
		$_SERVER['PHP_AUTH_USER'],
		$_SERVER['PHP_AUTH_PW']
		);
	}
	function forceLogged($role = NULL) {
		unset ($this->data, $this->user);
		list ($this->user, $pwd) = $this->getUserCredentials();
		if (!isset ($this->user)) {
			$this->die401();
		} else {
			$this->load();
			if ($this->data == NULL) {
				$this->die401();
			}
			$password = $this->data["password"];
			if ($password != null) {
				$result = crypt($pwd, $pwd);
			} else {
				$result = true;
			}
			if ($role != NULL) {
				if (!in_array($role, $this->data["role"])) {
					$this->die401();
				}
			}
			if ($result != $password) {
				$this->die403();
			} else {
				$_SESSION["url"] = null;
			}
		}
	}
}
?>