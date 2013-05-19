<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
function smarty_function_prologue($params, &$smarty) {
	global $PAGE;
	global $HANDSET;
	$c = (int) $HANDSET->getHandsetType();
	echo ("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>");
	echo ($HANDSET->getDocType());
	echo ("<html>");
	echo "<head>";
	if ($c != 2) { // not i-mode
		$icon = $params["icon"];
		if ($icon) {
			echo "<link rel=\"icon\" href=\"$icon\"/>";
		}
		$style = $PAGE->getStyleSheetURL();
		if ($style) {
			foreach ($style as $media => $url) {
				if ($media != "") {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" media=\"$media\"/>";
				} else {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\"/>";
				}
			}
		}
		echo "<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\" />";
	}
	echo "<title>" . $PAGE->getTitle() . "</title>";
	echo "</head>";
	echo "<body";
	if ($c != 3) { // not xhtml
		writeAttr($params, array (
      "bgColor",
      "background",
      "text",
      "alink",
      "vlink",
      "link"
      ));
	}
	echo ">";
}
?>