<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function smarty_function_hr($params, & $smarty) {
	$width = $params['width'];
	return render_hr($width);
}

function render_hr($width) {
	if ($width == '25') {
		return '<p align="center">---</p>';
	}
	else if ($width == '50') {
		return '<p align="center">------</p>';
	}
	else if ($width == '75') {
		return '<p align="center">---------</p>';
	}
	else {
		return '<p align="center">------------</p>';
	}
}
?>