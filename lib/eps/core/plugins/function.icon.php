<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR."core".DIR_SEP."plugins".DIR_SEP."function.image.php");
function render_icon(&$icon) {
	global $_SERVER;
	global $CONTEXT;
	global $HANDSET;
	$result = FALSE;
	if ($icon == NULL) {
		return;
	}
	foreach ($icon->images as $img) {
		$image = & getResourceById("TImage", $img);
		$fmt = $image->format;
		if ($fmt) {
			$var = "image_format_" . $fmt;
			$val = $HANDSET-> $var;
			if ($val) {
				render_IMAGE($image);
				$result = TRUE;
				break;
			}
		} else
		if ($image->mime_type) {
			global $_SERVER;
			$accept = $_SERVER[HTTP_ACCEPT];
			if ($accept) {
				if (strpos($accept, $image->mime_type) === FALSE) {
				} else {
					render_IMAGE($image);
					$result = TRUE;
					break;
				}
			}
		} else {
			render_IMAGE($image);
			$result = TRUE;
			break;
		}
	}
	if (!$result) {
		if ($icon->adapt) {
			$img = $icon->images[0];
			$img = & getResourceById("TImage", $img);
			if ($img) {
				$img->rescale = 2;
				if ($HANDSET->image_format_jpg) {
					$img->format = "jpg";
				} else
				if ($HANDSET->image_format_png) {
					$img->format = "png";
				} else {
					unset ($img);
				}
				if ($img) {
					render_IMAGE($img);
					$result = TRUE;
				}
			}
		}
	}
	if (!$result) {
		if ($icon->alt_text) {
			$result = true;
			echo ("$icon->alt_text");
		}
	}
	return $result;
}
function smarty_function_icon($params, &$smarty) {
	global $CONTEXT;
	$ref = $params["ref"];
	if ($ref) {
		$icon = & getResourceById("TIcon", $ref);
	} else {
		$icon = new TIcon($params);
	}
	if ($icon) {
		render_icon($icon);
	}
}
?>