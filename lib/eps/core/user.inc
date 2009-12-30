<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
class TAbstractUser {
	function TUser() {
		unset ($this->data, $this->user);
		list ($this->user, $pwd) = $this->getUserCredentials();
	}
	function load($user = null) {
		global $CONFIG;
		if ($user == null) {
			$user = $this->user;
		}
		if ($user) {
			$this->data = @ parse_ini_file($CONFIG["path_user"] . "$user.ini", true);
			if ($this->data != null) {
				$this->data["role"] = explode(":", $this->data["role"]);
			}
		} else {
			unset ($this->data);
		}
	}
	function supportRole($role) {
		if (!$this->data) {
			$this->load();
		}
		if ($this->data) {
			return (int) in_array($role, $this->data["role"]);
		}
		return 0;
	}
	function getUserInfo($info) {
		if ($this->data == null) {
			$this->forceLogged();
		}
		return $this->data[$info];
	}
}
?>