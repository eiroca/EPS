<?php
/**
 *
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site
 * Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest version of EIROCA PORTAL SYSTEM can be obtained from: http://www.eiroca.net
 *
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
if (!defined('EPS')) define('EPS', '0.5.2');
if (!defined('DIR_SEP')) define('DIR_SEP', DIRECTORY_SEPARATOR);
if (!defined('EPS_DIR')) define('EPS_DIR', dirname(__FILE__) . DIR_SEP);
if (!defined('LIB_DIR')) define('LIB_DIR', EPS_DIR . '..' . DIR_SEP);
if (!defined('SRV_DIR')) define('SRV_DIR', LIB_DIR . 'eps_services' . DIR_SEP);
if (!defined('EPS_HANDSET_DIR')) define('EPS_HANDSET_DIR', LIB_DIR . 'eps_handset' . DIRECTORY_SEPARATOR);
if (!defined('BASE_DIR')) define('BASE_DIR', LIB_DIR . '..' . DIR_SEP);
if (!defined('EPS_CORE_DIR')) define('EPS_CORE_DIR', EPS_DIR . 'core' . DIR_SEP);
// define(HTTP_PROXY_HOST, '10.1.24.4');
// define(HTTP_PROXY_PORT, '8080');
unset($CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE, $USER);
global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE, $USER;
@include ('eps_config.php');
require_once (EPS_CORE_DIR . 'context.php');
@include 'local_init.php';

function initContext($mode = 'mobile') {
	global $CONTEXT;
	if ($CONTEXT == NULL) {
		require_once (EPS_CORE_DIR . 'request_' . $mode . '.php');
		$CONTEXT = new TRequest();
	}
	return $CONTEXT;
}

function initHandset($ua = NULL) {
	global $HANDSET;
	if ($HANDSET == NULL) {
		require_once (EPS_CORE_DIR . 'handset.php');
		$HANDSET = loadHandset($ua);
	}
}

function initUser() {
	global $CONFIG;
	global $USER;
	if ($USER == NULL) {
		require_once (EPS_CORE_DIR . 'user_' . $CONFIG['user_auth'] . '.php');
		$USER = new TUser();
	}
}

function startsWith($haystack, $needle) {
	// search backwards starting from haystack length characters from the end
	return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function endsWith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

function get_absolute_path($path) {
	$path = str_replace(array (
			'/', 
			'\\' 
	), DIRECTORY_SEPARATOR, trim($path));
	$isUnix = startsWith($path, DIRECTORY_SEPARATOR);
	$isPath = endsWith($path, DIRECTORY_SEPARATOR);
	$parts = explode(DIRECTORY_SEPARATOR, $path);
	$absolutes = array ();
	foreach ($parts as $part) {
		if ('' == $part) continue;
		if ('.' == $part) continue;
		if ('..' == $part) {
			array_pop($absolutes);
		}
		else {
			$absolutes[] = $part;
		}
	}
	$res = ($isUnix ? DIRECTORY_SEPARATOR : '') . implode(DIRECTORY_SEPARATOR, $absolutes) . ($isPath ? DIRECTORY_SEPARATOR : '');
	return $res;
}
?>
