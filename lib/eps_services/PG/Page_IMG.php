<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2010 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.1
 * @link http://www.eiroca.net
 */
require_once (SRV_DIR."PG".DIR_SEP."PGPage.php");
class Page extends PGPage {
	var $cid;
	var $iid;
	var $caption;
	var $cat;
	var $images;
	var $i_pos;
	var $i_count;
	function Page(&$res) {
		parent::PGPage($res);
		global $_REQUEST;
		$this->iid = $_REQUEST["i"];
		$this->cid = $_REQUEST["c"];
		$this->_cacheKey[] = $this->cid;
		$this->_cacheKey[] = $this->iid;
	}
	function setup(&$cached) {
		if (!$cached) {
			global $CONTEXT;
			global $HANDSET;
			$this->images = explode(" ", $this->conf["category_$this->cid"]["files"]);
			$this->cat = $this->conf["category_$this->cid"]["caption"];
			foreach ($this->conf["file_$this->iid"] as $nam => $val) {
				$name = "img_" . $nam;
				$this-> $name = $val;
			}
			$this->i_pos = array_search($this->iid, $this->images) + 1;
			$this->i_count = count($this->images);
			$prv = $this->i_pos - 2;
			$nxt = $this->i_pos;
			if ($prv < 0) {
				$prv = $this->i_count - 1;
			}
			if ($nxt >= $this->i_count) {
				$nxt = 0;
			}
			$def["caption"] = "&gt;&gt;";
			$def["style"] = 1;
			$def["url"] = "#service#?s=PG&amp;a=IMG&amp;c=$this->cid&amp;i=" . $this->images[$nxt];
			$this->register_link("PG_next", new TLink($def));
			$def["caption"] = "&lt;&lt;";
			$def["url"] = "#service#?s=PG&amp;a=IMG&amp;c=$this->cid&amp;i=" . $this->images[$prv];
			$this->register_link("PG_prev", new TLink($def));
			$def["caption"] = "elenco";
			$def["url"] = "#service#?s=PG&amp;a=CAT&amp;c=$this->cid";
			$def["icon"] = "system_dot3";
			unset ($def["style"]);
			$this->register_link("PG_elenco", new TLink($def));
			unset ($def);
			$file = $this->conf["file_$this->iid"]["path"] . $this->conf["file_$this->iid"]["file"];
			$w = $HANDSET->display_max_image_width;
			if ($w == NULL) {
				$w = $HANDSET->display_resolution_width;
			}
			if ($w > 352) {
				$w = 352;
			}
			$def["alt_text"] = $this->img_caption;
			$def["width"] = $w;
			$def["url"] = $file;
			$def["rescale"] = true;
			//    $def["prefix"] = "prefix_id";
			//    $def["hidename"] = true;
			$def["format"] = "jpg";
			$def["mime_type"] = "image/jpeg";
			$this->register_image("_IMG", new TImage($def));
			unset ($def);
			$def["images"] = "_IMG";
			$def["alt_text"] = "[[immagine non disponibile]]";
			$this->register_icon("IMG", new TIcon($def));
		}
	}
	function getTemplate() {
		return "picture";
	}
	function getFooterLinks() {
		return array ("PG_elenco","PG_home");
	}
}
?>