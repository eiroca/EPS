<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
class TRequest extends TContext {

	function TRequest() {
		parent::TContext();
		header('P3P: CP="STA"');
		session_name('SID');
		session_start();
	}

	function process() {
		global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
		initHandset();
		header('Content-Type: text/css');
		header('Cache-control: max-age=86400');
		$what = array ();
		$service = urlencode($this->getRequestVAR(KEY_SERVICE));
		$class = urlencode($this->getRequestVAR(KEY_CLASS, null));
		$model = urlencode($HANDSET->product_info_brand_name . $HANDSET->product_info_model_name);
		if ($class == null) {
			$class = $this->decodeRenderClass();
		}
		if ($model) {
			$what = array (
					'style_' . $model . '.php', 'style_' . $class . '.php', 'style.php' 
			);
		}
		else {
			$what = array (
					'style_' . $class . '.php', 'style.php' 
			);
		}
		$base = '.' . DIR_SEP . $CONFIG['relpath_config'] . DIR_SEP;
		$ok = $this->find($base, $what);
		if ($ok) {
			include $ok;
		}
		if ($service) {
			$base = SRV_DIR . $service . DIR_SEP . $CONFIG['relpath_config'] . DIR_SEP;
			$ok = $this->find($base, $what);
			if ($ok) {
				include $ok;
			}
		}
		$this->logAccess(smarty_core_get_microtime('', $this) - $this->_begintime, $service, 'css');
	}
}
?>