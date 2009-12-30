<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
class TRequest extends TContext {
	function TRequest() {
		parent :: TContext();
		header("P3P: CP=\"STA\"");
		session_name("SID");
		session_start();
	}
	function process() {
		global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
		global $_REQUEST;
		initHandset();
		header("Content-Type: text/css");
		header("Cache-control: max-age=86400");
		$what = array ();
		$service = urlencode($_REQUEST[KEY_SERVICE]);
		$model = urlencode($HANDSET->product_info_brand_name . $HANDSET->product_info_model_name);
		$class = urlencode($_REQUEST[KEY_CLASS]);
		if ($class == null) {
			$class = $this->decodeRenderClass();
		}
		if ($model) {
			$what = array (
        "style_" . $model . ".inc",
        "style_" . $class . ".inc",
        "style.inc"
        );
		} else {
			$what = array (
        "style_" . $class . ".inc",
        "style.inc"
        );
		}
		$base = "./" . $CONFIG["relpath_config"] . "/";
		$ok = $this->find($base, $what);
		if ($ok) {
			include $ok;
		}
		if ($service) {
			$base = SRV_DIR . $service . "/" . $CONFIG["relpath_config"] . "/";
			$ok = $this->find($base, $what);
			if ($ok) {
				include $ok;
			}
		}
		$this->logAccess(smarty_core_get_microtime("", $this) - $this->_begintime, $service, "css");
	}
}
?>