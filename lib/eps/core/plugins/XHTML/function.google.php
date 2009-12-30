<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
global $CONFIG;
@include_once ($CONFIG["path_banner"] . "google.inc");
function smarty_function_google($params, & $smarty) {
	global $ADS;
	global $CONFIG;
	if ($CONFIG["ADS"] != null) {
		$ADS = "E";
		if (function_exists('google_get_ad_url')){
			$URL = google_get_ad_url();
			if ($URL != null) {
				$google_ad_handle = @fopen($URL, 'r');
				if ($google_ad_handle) {
					$ADS = "Y";
					while (!feof($google_ad_handle)) {
						echo fread($google_ad_handle, 8192);
						$ADS = "G";
					}
					fclose($google_ad_handle);
				}
			}
		}
	}
}
?>