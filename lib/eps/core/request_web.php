<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function getBool($parm) {
	global $DATA;
	if (isset($DATA[$parm])) {
		return (boolean)$DATA[$parm];
	}
	else {
		return false;
	}
}

class TTemplate {
	var $icoPath = 'ico/';
	var $cssPath = 'css/';
	var $logoPath = '';

	function checkProtected() {
		global $DATA;
		global $USER;
		if (isset($DATA['protected'])) {
			$p = $DATA['protected'];
			if ($p != 'true') {
				$USER->forceLogged($p);
			}
			else {
				$USER->forceLogged();
			}
		}
	}

	function head() {
		global $DATA;
		global $INDEX;
		global $CONTEXT;
		global $CONFIG;
		if (isset($DATA['icon'])) {
			$ico = $DATA['icon'];
		}
		else {
			$ico = 'eiroca.ico';
		}
		if (isset($DATA['css'])) {
			$css = $DATA['css'];
		}
		else {
			$css = 'eiroca.css';
		}
		echo '<link rel="icon" href="' . $CONFIG['path_static'] . $this->icoPath . $ico . '"/>';
		echo '<link rel="stylesheet" type="text/css" href="' . $CONFIG['path_static'] . $this->cssPath . $css . '"/>';
		echo '<title>' . $DATA['title'] . '</title>';
		if (getBool('ajax') | getBool('script')) {
			echo '<script type="text/javascript">';
			if (getBool('ajax')) {
				sajax_show_javascript();
			}
			$CONTEXT->execute('script.php');
			echo '</script>';
		}
	}

	function home() {
		global $DATA;
		global $CONFIG;
		if (isset($DATA['home'])) {
			$url = 'index.php?page=' . $DATA['home'];
		}
		else {
			$url = 'index.php';
		}
		if (isset($DATA['logo'])) {
			$logo = $DATA['logo'];
		}
		else {
			$logo = 'eiroca.gif';
		}
		if (isset($DATA['logo_alt'])) {
			$logo_alt = $DATA['logo_alt'];
		}
		else {
			$logo_alt = 'eIrOcA';
		}
		echo '<a href="' . $url . '"><img src="' . $CONFIG['path_static'] . $this->logoPath . $logo . '" alt="' . $logo_alt . '"/></a>';
	}

	function title() {
		global $DATA;
		echo $DATA['title'];
	}

	function bottom() {
		global $DATA;
		if (isset($DATA['message'])) {
			echo $DATA['message'];
		}
	}

	function generateMenu($menu) {
		global $USER;
		global $CONFIG;
		if (count($menu) > 0) {
			echo '<table class="MENU_LIST">';
			foreach ($menu as $item) {
				$type = (int)@$item['type'];
				switch ($type) {
					case 1 :
						echo '<tr><td>&nbsp;</td></tr>';
						break;
					case 2 :
						$width = $item['width'];
						if ($width == NULL) {
							$width = '100%';
						}
						echo '<tr><td><hr width="' . $width . '"/></td></tr>';
						break;
					default :
						$role = @$item['role'];
						$icon = @$item['icon'];
						$url = @$item['url'];
						$caption = @$item['caption'];
						$image = @$item['image'];
						$style = (int)@$item['style'];
						if ($caption == NULL) {
							$caption = '-';
						}
						if ($url == NULL) {
							$url = '.';
						}
						if ($icon == NULL) {
							$icon = $CONFIG['path_static'] . 'minilogo.gif';
						}
						if ($role != NULL) {
							if (!$USER->supportRole($role)) {
								continue;
							}
						}
						echo '<tr><td><a class="MENU_LINK" href="' . $url . '"><span class="MENU_ICON"><img src="' . $icon . '" alt="-"/></span>';
						switch ($style) {
							case 1 :
								echo '<span class="MENU_TEXT">' . $caption . ' <img src="' . $image . '" alt="-"/></span>';
								break;
							case 2 :
								echo '<span class="MENU_TEXT"><img src="' . $image . '" alt="-"/> ' . $caption . '</span>';
								break;
							default :
								echo '<span class="MENU_TEXT">' . $caption . '</span>';
								break;
						}
						echo '</a></td></tr>';
						break;
				}
			}
			echo '</table>';
		}
	}

	function version() {
		global $DATA;
		global $MESSAGES;
		$br = false;
		if (isset($DATA['version']) | isset($DATA['last_modify'])) {
			if (isset($DATA['version'])) {
				echo ($MESSAGES['version'] . $DATA['version']);
				$br = true;
			}
			if (isset($DATA['last_modify'])) {
				if ($br) {
					echo '<br/>';
				}
				echo ($MESSAGES['last_modify'] . $DATA['last_modify']);
				$br = true;
			}
		}
		if (isset($DATA['copyright_url'])) {
			if ($br) {
				echo '<br/>';
			}
			if (isset($DATA['copyright_caption'])) {
				$text = $DATA['copyright_caption'];
			}
			else {
				$text = 'Copyright';
			}
			echo sprintf("<a href=\"%s\">%s</a>", $DATA['copyright_url'], $text);
		}
	}
}

class TRequest extends TContext {

	function TRequest() {
		parent::TContext();
		header('P3P: CP="STA"');
		session_name('WID');
		session_start();
	}

	function loadIndex() {
		global $INDEX;
		if ($INDEX == NULL) {
			global $CONFIG;
			$index_file = $CONFIG['path_indexfile'] . $CONFIG['file_indexfile'];
			if (!file_exists($index_file)) {
				require_once (EPS_DIR . 'setup' . DIR_SEP . 'buildWebIndex.php');
				buildWebIndex($index_file);
			}
			$INDEX = parse_ini_file($index_file, true);
		}
	}

	function execute($section) {
		global $serviceID;
		global $INDEX;
		$this->loadIndex();
		if (isset($INDEX[$this->serviceID])) {
			$sez = $INDEX[$this->serviceID];
		}
		else {
			$sez = $INDEX;
		}
		$ok = true;
		while ($ok) {
			$valid = $sez['valid'];
			$path = $sez['path'] . DIR_SEP . $section;
			if (($valid) & (file_exists($path))) {
				include $path;
				break;
			}
			else {
				if (isset($sez['parent'])) {
					$parent = $sez['parent'];
					$sez = $INDEX[$parent];
				}
				else {
					$ok = false;
					$sez = $INDEX;
					$path = $sez['path'] . DIR_SEP . $section;
					include $path;
				}
			}
		}
	}

	function process() {
		global $TEMPLATE;
		global $DATA;
		$this->serviceID = urlencode($this->getRequestVAR('page'));
		$action = urlencode($this->getRequestVAR('action'));
		if ($action != null) {
			require_once ('action.php');
			run_action($action);
		}
		$TEMPLATE = new TTemplate();
		initUser();
		$this->execute('metadata.inc');
		if (getBool('ajax')) {
			global $GLOBALS;
			require LIB_DIR . 'utils' . DIR_SEP . 'Sajax.php';
			sajax_init();
			$this->execute('ajax.php');
			if (sajax_handle_client_request()) {
				$this->logAccess(smarty_core_get_microtime('', $this) - $this->_begintime, $this->serviceID . '-ajax');
				exit();
			}
		}
		$this->execute('page.inc');
		$this->logAccess(smarty_core_get_microtime('', $this) - $this->_begintime, $this->serviceID);
	}
}
?>