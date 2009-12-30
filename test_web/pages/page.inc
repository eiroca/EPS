<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
global $TEMPLATE; $TEMPLATE->checkProtected(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php global $CONTEXT; $CONTEXT->execute("HEAD.inc"); ?>
</head>
<body>
<table class="PAGE">
	<tr class="TOP">
		<td class="TOP_HOME"><?php global $CONTEXT; $CONTEXT->execute("HOME.inc"); ?></td>
		<td class="TOP_TITLE" colspan="2"><?php global $CONTEXT; $CONTEXT->execute("TITLE.inc"); ?></td>
	</tr>
	<tr>
		<td class="MENU" rowspan="2" align="left" valign="top"><?php global $CONTEXT; $CONTEXT->execute("MENU.inc"); ?></td>
		<td class="BANNER_TOP" colspan="2"><?php global $CONTEXT; $CONTEXT->execute("BANNER.inc"); ?></td>
	</tr>
	<tr>
		<td class="CONTENT" colspan="2"><?php global $CONTEXT; $CONTEXT->execute("BODY.inc"); ?></td>
	</tr>
	<tr>
		<td class="VERSION"><?php global $CONTEXT; $CONTEXT->execute("VERSION.inc"); ?></td>
		<td class="BANNER_BOTTOM" colspan="2"><?php global $CONTEXT; $CONTEXT->execute("BOTTOM.inc"); ?></td>
	</tr>
</table>
</body>
</html>

