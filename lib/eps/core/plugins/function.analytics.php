<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
function googleAnalyticsGetImageUrl($id) {
 $url = "/ga.php?utmac=".$id."&utmn=".rand(0, 0x7fffffff);
 $referer = $_SERVER["HTTP_REFERER"];
 $path = $_SERVER["REQUEST_URI"];
 if (empty($referer)) { $referer = "-"; }
 $url .= "&utmr=" . urlencode($referer);
 if (!empty($path)) {$url .= "&utmp=" . urlencode($path); }
 $url .= "&guid=ON";
 return $url;
}
function smarty_function_analytics($params, &$smarty) {
 $ID = $params["id"];
 echo '<img src="' . googleAnalyticsGetImageUrl($ID) . '" alt="" width="1" height="1" />';
 return $out;
}
?>