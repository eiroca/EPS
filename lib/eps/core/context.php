<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (LIB_DIR . 'utils' . DIR_SEP . 'smarty' . DIR_SEP . 'internals' . DIR_SEP . 'core.get_microtime.php');
define('KEY_SERVICE', 's');
define('KEY_ACTION', 'a');
define('KEY_CLASS', 'c');
define('KEY_DEF_SERVICE', 'HP');

class TContext {
	var $_begintime;

	function TContext() {
		$this->_begintime = smarty_core_get_microtime('', $this);
	}

	function redirect($url, $mode = NULL) {
		if ($mode != NULL) {
			header('Status: ' . $mode . ' Redirect');
		}
		header('Location: ' . $url);
	}

	function decodeRenderClass() {
		global $HANDSET;
		$c = $HANDSET->getHandsetType();
		if ((int)$c == 0) {return 'WML';}
		return 'XHTML';
	}

	function decodeServiceID($serviceID = NULL, $defServiceID = NULL) {
		if ($serviceID == NULL) {
			$serviceID = urlencode($this->getRequestVAR(KEY_SERVICE, $defServiceID));
		}
		return $serviceID;
	}

	function find(& $path, & $what) {
		foreach ($what as $file) {
			$full = $path . $file;
			if (file_exists($full)) {return $full;}
		}
		return null;
	}

	function getServerVAR($var, $def = NULL) {
		global $_SERVER;
		if (isset($_SERVER[$var])) {
			return $_SERVER[$var];
		}
		else {
			return $def;
		}
	}

	function getRequestVAR($var, $def = NULL) {
		global $_REQUEST;
		if (isset($_REQUEST[$var])) {
			return $_REQUEST[$var];
		}
		else {
			return $def;
		}
	}

	function logAccess($elapsed, $serviceID, $knd = '') {
		global $CONFIG;
		global $ADS;
		if ($ADS == null) {
			$ADS = '-';
		}
		$today = date('Ymd', time());
		$log_filename = sprintf($CONFIG['path_log'] . $CONFIG['file_accesslog'], $today);
		if ($log_filename != NULL) {
			global $HANDSET;
			if ($HANDSET != null) {
				$hid = $HANDSET->ID . '-' . $HANDSET->getHandsetType();
			}
			else {
				$hid = '';
			}
			$remote = $this->getServerVAR('REMOTE_ADDR');
			$user = $this->getServerVAR('PHP_AUTH_USER');
			$query = $this->getServerVAR('QUERY_STRING');
			$path = $this->getServerVAR('PATH_INFO');
			if ($path == '') {
				$path = '/';
			}
			$gmt = date('d/m/Y:H:i:s', time());
			$referer = $this->getServerVAR('HTTP_REFERER');
			$agent = $this->getServerVAR('HTTP_USER_AGENT');
			$sid = session_id();
			$logline = sprintf("%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n", $gmt, $serviceID, $knd, (int)($elapsed * 1000), $hid, $sid, $remote, $user, $query, $referer, $agent, $ADS);
			$f = fopen($log_filename, 'a+');
			fputs($f, $logline);
			fclose($f);
		}
	}

	function touchCounter($name) {
		require_once (EPS_CORE_DIR . 'context_utils.php');
		return _utils_touchCounter($name);
	}

	function errorTrace($msg) {
		require_once (EPS_CORE_DIR . 'context_utils.php');
		_utils_errorTrace($msg);
	}

	function processFilter($filter, $cond = null) {
		require_once (EPS_CORE_DIR . 'context_filter.php');
		if ($cond) {
			$prm = split(' ', $cond);
			$cmd = '_filter_' . $filter;
		}
		else {
			$prm = split(' ', $filter);
			$cmd = '_filter_' . array_shift($prm);
		}
		return $cmd($prm);
	}
}
?>