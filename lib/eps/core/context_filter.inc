<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
function _filter_handset(& $params) {
	global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
	$prop = array_shift($params);
	$val = array_shift($params);
	$p = $HANDSET-> $prop;
	if ($val != NULL) {
		return $p == $val;
	}
	return ($p != null);
}
function _filter_supportRole(& $params) {
	global $USER;
	initUser();
	$role = array_shift($params);
	$val = array_shift($params);
	if ($val === NULL) {
		$val = 1;
	} else {
		$val = (int) $val;
	}
	$res = $USER->supportRole($role);
	return $res == $val;
}
function _filter_link(& $params) {
	global $CONTEXT;
	$ref = array_shift($params);
	$val = array_shift($params);
	if ($val === NULL) {
		$val = 1;
	} else {
		$val = (int) $val;
	}
	$res = 0;
	if ($ref) {
		$link = & getResourceById("TLink", $ref);
		if ($link) {
			$res = 1;
		}
	}
	return $res == $val;
}
function _filter_renderclass(& $params) {
	global $CONTEXT;
	$it = array_shift($params);
	$val = array_shift($params);
	if ($val === NULL) {
		$val = 1;
	} else {
		$val = (int) $val;
	}
	$ht = $CONTEXT->renderClass;
	$res = (int) ($ht == $it);
	return ($val == $res);
}
?>