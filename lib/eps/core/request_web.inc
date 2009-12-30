<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
class TTemplate {
	var $icoPath = "ico/";
	var $cssPath = "css/";
	var $logoPath = "";
	function checkProtected() {
		global $DATA;
		global $USER;
		if ($DATA["protected"]) {
			$p = $DATA["protected"];
			if ($p <> "true") {
				$USER->forceLogged($p);
			} else {
				$USER->forceLogged();
			}
		}
	}
	function head() {
		global $DATA;
		global $INDEX;
		global $CONTEXT;
		global $CONFIG;
		$ico = $DATA["icon"];
		if ($ico == null) {
			$ico = "eiroca.ico";
		}
		$css = $DATA["css"];
		if ($css == null) {
			$css = "eiroca.css";
		}
		echo "<link rel=\"icon\" href=\"" . $CONFIG["path_static"] . $this->icoPath . $ico . "\"/>";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $CONFIG["path_static"] . $this->cssPath . $css . "\"/>";
		echo "<title>" . $DATA["title"] . "</title>";
		if ($DATA["ajax"] | $DATA["script"]) {
			echo "<script type=\"text/javascript\">";
			if ($DATA["ajax"]) {
				sajax_show_javascript();
			}
			$CONTEXT->execute("script.inc");
			echo "</script>";
		}
	}
	function home() {
		global $DATA;
		global $CONFIG;
		if ($DATA["home"]) {
			$url = "index.php?page=" . $DATA["home"];
		} else {
			$url = "index.php";
		}
		$logo = $DATA["logo"];
		if ($logo == null) {
			$logo = "eiroca.gif";
		}
		$logo_alt = $DATA["logo_alt"];
		if ($logo_alt == null) {
			$logo_alt = "eIrOcA";
		}
		echo "<a href=\"$url\"><img src=\"" . $CONFIG["path_static"] . $this->logoPath . $logo . "\" alt=\"" . $logo_alt . "\"/></a>";
	}
	function title() {
		global $DATA;
		echo $DATA["title"];
	}
	function bottom() {
		global $DATA;
		if ($DATA["message"]) {
			echo $DATA["message"];
		}
	}
	function generateMenu($menu) {
		global $USER;
		global $CONFIG;
		if (count($menu) > 0) {
			echo "<table class=\"MENU_LIST\">";
			foreach ($menu as $item) {
				$type = (int) $item["type"];
				switch ($type) {
					case 1 :
						echo "<tr><td>&nbsp;</td></tr>";
						break;
					case 2 :
						$width = $item["width"];
						if ($width == NULL) {
							$width = "100%";
						}
						echo "<tr><td><hr width=\"" . $width . "\"/></td></tr>";
						break;
					default :
						$role = $item["role"];
						$icon = $item["icon"];
						$url = $item["url"];
						$caption = $item["caption"];
						$image = $item["image"];
						$style = (int) $item["style"];
						if ($caption == NULL) {
							$caption = "-";
						}
						if ($url == NULL) {
							$url = ".";
						}
						if ($icon == NULL) {
							$icon = $CONFIG["path_static"]."minilogo.gif";
						}
						if ($role != NULL) {
							if (!$USER->supportRole($role)) {
								continue;
							}
						}
						echo "<tr><td><a class=\"MENU_LINK\" href=\"$url\"><span class=\"MENU_ICON\"><img src=\"$icon\" alt=\"-\"/></span>";
						switch ($style) {
							case 1 :
								echo "<span class=\"MENU_TEXT\">$caption <img src=\"$image\" alt=\"-\"/></span>";
								break;
							case 2 :
								echo "<span class=\"MENU_TEXT\"><img src=\"$image\" alt=\"-\"/> $caption</span>";
								break;
							default :
								echo "<span class=\"MENU_TEXT\">$caption</span>";
								break;
						}
						echo "</a></td></tr>";
						break;
				}
			}
			echo "</table>";
		}
	}
	function version() {
		global $DATA;
		global $MESSAGES;
		$br = false;
		if ($DATA["version"] | $DATA["last_modify"]) {
			if ($DATA["version"]) {
				echo ($MESSAGES["version"] . $DATA["version"]);
				$br = true;
			}
			if ($DATA["last_modify"]) {
				if ($br) {
					echo "<br/>";
				}
				echo ($MESSAGES["last_modify"] . $DATA["last_modify"]);
				$br = true;
			}
		}
		if ($DATA["copyright_url"]) {
			if ($br) {
				echo "<br/>";
			}
			$text = $DATA["copyright_caption"];
			if (!$text) {
				$text = "Copyright";
			}
			echo "<a href=\"" . $DATA["copyright_url"] . "\">$text</a>";
		}
	}
}
class TRequest extends TContext {
	function TRequest() {
		parent :: TContext();
		header("P3P: CP=\"STA\"");
		session_name("WID");
		session_start();
	}
	function loadIndex() {
		global $INDEX;
		if ($INDEX == NULL) {
			global $CONFIG;
			$index_file = $CONFIG["path_indexfile"] . $CONFIG["file_indexfile"];
			if (!file_exists($index_file)) {
				require_once (EPS_DIR . "setup" . DIR_SEP . "buildWebIndex.inc");
				buildWebIndex($index_file);
			}
			$INDEX = parse_ini_file($index_file, true);
		}
	}
	function execute($section) {
		global $serviceID;
		global $INDEX;
		$this->loadIndex();
		$sez = $INDEX[$this->serviceID];
		if ($sez == NULL) {
			$sez = $INDEX;
		}
		$ok = true;
		while ($ok) {
			$valid = $sez["valid"];
			$path = $sez["path"] . "/" . $section;
			if (($valid) & (file_exists($path))) {
				include $path;
				break;
			} else {
				$parent = $sez["parent"];
				if (!$parent) {
					$ok = false;
					$sez = $INDEX;
					$path = $sez["path"] . "/" . $section;
					include $path;
				} else {
					$sez = $INDEX[$parent];
				}
			}
		}
	}
	function process() {
		global $TEMPLATE;
		global $DATA;
		$this->serviceID = urlencode($_REQUEST["page"]);
		$action = urlencode($_REQUEST["action"]);
		if ($action != null) {
			require_once ("action.inc");
			run_action($action);
		}
		$TEMPLATE = new TTemplate();
		initUser();
		$this->execute("metadata.inc");
		if ($DATA["ajax"]) {
			global $GLOBALS;
			require LIB_DIR . "utils" . DIR_SEP . "Sajax.php";
			sajax_init();
			$this->execute("ajax.inc");
			if (sajax_handle_client_request()) {
				$this->logAccess(smarty_core_get_microtime("", $this) - $this->_begintime, $this->serviceID."-ajax");
				exit;
			}
		}
		$this->execute("page.inc");
		$this->logAccess(smarty_core_get_microtime("", $this) - $this->_begintime, $this->serviceID);
	}
}
?>