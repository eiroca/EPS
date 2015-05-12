<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
require_once (LIB_DIR . 'utils' . DIR_SEP . 'Image_Toolbox.class.php');
require_once (LIB_DIR . 'utils' . DIR_SEP . 'smarty' . DIR_SEP . 'internals' . DIR_SEP . 'core.create_dir_structure.php');

function cacheImage(& $image) {
	global $CONFIG;
	$dynamic = $CONFIG['path_dynamic'];
	$newfmt = ($image->rescale & 2) == 2;
	$path = $image->url;
	$path_parts = pathinfo($path);
	if ($image->hidename) {
		$nam = abs(crc32($path_parts['basename'])) . '.' . $image->format;
		$nam_url = $nam;
	}
	else {
		if ($newfmt) {
			$bn = $path_parts['basename'];
			$ex = $path_parts['extension'];
			$nam = substr($bn, 0, (strlen($bn) - strlen($ex) - 1)) . '.' . $image->format;
			$nam = urlencode(ereg_replace(' ', '', $nam));
		}
		else {
			$nam = urlencode(ereg_replace(' ', '', $path_parts['basename']));
		}
	}
	$w = (int)$image->width;
	$h = (int)$image->height;
	if ($image->prefix) {
		$prefix = $image->prefix;
	}
	else {
		$prefix = 'imgs/' . $w . '/' . $h . '/' . abs(crc32($path_parts['dirname']));
	}
	$m = (int)$image->mode;
	$bgcol = $image->bgcolor;
	$params['dir'] = $dynamic . $prefix;
	$out = $dynamic . $prefix . '/' . $nam;
	if (!file_exists($out)) {
		global $CONTEXT, $RENDER;
		smarty_core_create_dir_structure($params, $RENDER->smarty);
		$toolbox = new Image_Toolbox($path);
		if (($image->rescale & 1) == 1) {
			$toolbox->newOutputSize($w, $h, $image->mode, $image->autorotate, $image->bgcolor);
		}
		if ($newfmt) {
			$toolbox->save($out, $image->format, $image->output_quality, $image->dither);
		}
		else {
			$toolbox->save($out);
		}
	}
	return $out;
}

function render_image(& $image) {
	global $CONTEXT;
	global $HANDSET;
	$text = $image->alt_text;
	$href = $image->url;
	if ($image->rescale) {
		$href = cacheImage($image);
	}
	echo ('<img src="' . $href . '" alt="' . $text . '"');
	if (!$image->rescale) {
		if ($image->width) {
			echo (' width="' . $image->width . '"');
		}
		if ($image->height) {
			echo (' height="' . $image->height . '"');
		}
	}
	echo ('/>');
	if ($image->style == 1) {
		echo $HANDSET->BR();
	}
}

function smarty_function_image($params, & $smarty) {
	global $CONTEXT;
	$ref = $params['ref'];
	if ($ref) {
		$image = & getResourceById('TImage', $ref);
	}
	else {
		$image = new TImage($params);
	}
	if ($image) {
		render_image($image);
	}
}
?>