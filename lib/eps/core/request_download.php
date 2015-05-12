<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2015 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.2
 * @link http://www.eiroca.net
 */
function read_char(&$f) {
	$c = fgetc($f);
	if ($c == "\r") {
		$c = "\n";
	}
	return $c;
}

function read_line(&$f) {
	$line = '';
	while (!feof($f)) {
		$c = read_char($f);
		if ($c == "\n") {
			if ($line != '') {
				break;
			}
		}
		else {
			$line = $line . $c;
		}
	}
	return $line . "\n";
}

class TRequest extends TContext {
	var $configuration;
	var $agent;
	var $id;
	var $file;
	var $type;
	var $action;
	var $category;
	var $status;
	var $resource;
	var $SID;
	var $SIZE;

	function TRequest() {
		parent::TContext();
		header('P3P: CP="STA"');
		$sessionName = urlencode($this->getRequestVAR('s', 'SID'));
		session_name($sessionName);
		session_start();
		$this->SID = session_id();
	}

	function decodeRequest() {
		$this->agent = $this->getServerVAR('HTTP_USER_AGENT');
		$this->file = urlencode($this->getRequestVAR('f'));
		$this->id = urlencode($this->getRequestVAR('n', 'default'));
		$this->type = urlencode($this->getRequestVAR('t', 'jad'));
		if ($this->type === 'jad') {
			$defAct = 'I';
		}
		else {
			$defAct = 'D';
		}
		$this->action = urlencode($this->getRequestVAR('a', $defAct));
		$this->category = urlencode($this->getRequestVAR('c', '000'));
		$this->status = 200;
	}

	function process($serviceID = NULL, $defServiceID = NULL, $renderClass = NULL, $userAgent = NULL) {
		global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
		$this->decodeRequest();
		$this->configuration = $this->load_metadata();
		$this->serveRequest();
		$this->logRequest();
	}

	function serveRequest() {
		if ($this->file) {
			$this->resource = YADS_DATA . DIR_SEP . $this->file;
		}
		else {
			$res = 'file_' . $this->id;
			$this->resource = $this->configuration[$res]['path'] . $this->configuration[$res]['basename'];
			if ($this->resource != '') {
				$this->resource .= '.' . $this->type;
			}
		}
		$this->SIZE = 0;
		if (!file_exists($this->resource)) {
			$this->status = 404;
			header('Location: ' . REDIR_PATH);
		}
		else if ($this->action == 'I') {
			$this->SIZE = $this->process_jad($this->id, $this->resource);
		}
		else if ($this->action == 'C') {
			$this->SIZE = $this->process_cer($this->id, $this->resource);
		}
		else if ($this->action == 'D') {
			$this->SIZE = $this->process_jar($this->resource);
		}
		else if ($this->action == 'NI') {
			$this->SIZE = $this->process_notify($this->resource);
		}
		else if ($this->action == 'ND') {
			$this->SIZE = $this->process_notify($this->resource);
		}
	}

	function load_metadata() {
		$index = YADS_INDEX . 'download_' . $this->category . '.ini';
		$this->check_metadata($index, $this->category);
		return parse_ini_file($index, true);
	}

	function check_metadata($index, $category) {
		if (!file_exists($index)) {
			include EPS_DIR . 'setup' . DIR_SEP . 'buildIndex.php';
			buildIndex($index, YADS_DATA . DIR_SEP . $category, array (
					'.jad' 
			));
		}
	}

	function logRequest() {
		$remote = $this->getServerVAR('REMOTE_ADDR');
		$gmt = date('Y/m/d:H:i:s', time());
		$today = date('Ymd', time());
		$log_filename = sprintf(YADS_LOGPATH, $today);
		$logline = sprintf("%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\t%s\n", $gmt, $this->action, $this->id, $this->resource, $this->status, $this->SIZE, $remote, $this->SID, $this->agent);
		$f = fopen($log_filename, 'a+');
		fputs($f, $logline);
		fclose($f);
	}

	function process_jad($id, &$fn) {
		$f = fopen($fn, 'r');
		$empty = false;
		$out = '';
		$out .= sprintf("MIDlet-Jar-URL: %s?n=%s&t=jar\n", YADS_URL, $id);
		$out .= sprintf("MIDlet-Install-Notify: %s?n=%s&a=NI\n", YADS_URL, $id);
		$out .= sprintf("MIDlet-Delete-Notify: %s?n=%s&a=ND\n", YADS_URL, $id);
		while (!feof($f)) {
			$l = read_line($f);
			if ($l == '') {
				if ($empty) {
					break;
				}
				else {
					$empty = true;
				}
			}
			else {
				$empty = false;
				if (strncasecmp($l, "MIDlet-Jar-URL", 14) === 0) {
					$l = '';
				}
				elseif (strncasecmp($l, 'MIDlet-Install-Notify', 21) === 0) {
					$l = '';
				}
				elseif (strncasecmp($l, 'MIDlet-Delete-Notify', 20) === 0) {
					$l = '';
				}
				if (trim($l) != '') {
					$out = $out . $l;
				}
			}
		}
		fclose($f);
		$size = strlen($out);
		header('Content-Description: eIrOcA download');
		header('Content-Disposition: attachment; filename=' . basename($fn));
		Header('Content-Type: text/vnd.sun.j2me.app-descriptor');
		Header('Content-Length: ' . $size);
		echo $out;
		return $size;
	}

	function process_cer($id, &$fn) {
		$size = filesize($fn);
		$bn = basename($fn);
		header('Content-Description: eIrOcA Certificate');
		header('Content-Type: application/x-x509-ca-cert');
		header('Content-Disposition: attachement; filename=' . $bn);
		header('Content-Length: ' . $size);
		$c = file_get_contents($fn);
		echo $c;
		return $size;
	}

	function process_jar(&$fn) {
		$size = filesize($fn);
		header('Content-Description: eIrOcA download');
		header('Content-Disposition: attachment; filename=' . basename($fn));
		header('Content-Type: application/java-archive');
		header('Content-Length: ' . $size);
		$c = file_get_contents($fn);
		echo $c;
		return $size;
	}

	function process_notify(&$fn) {
		$statusCode = file_get_contents('php://input');
		global $status;
		$status = urlencode(trim($statusCode));
		return strlen($status);
	}
}
?>
