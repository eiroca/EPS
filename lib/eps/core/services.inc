<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class TAction {
  var $_stateless = true;
  function execute() {
    return array ();
  }
}
class TService {
  var $namespace;
  var $actionID;
  var $pageID;
  var $securityRole;
  function getConfigDir() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $dirs= array (
      "./" . $CONFIG["relpath_config"] . "/" . $this->namespace,
      SRV_DIR . $CONFIG["relpath_config"] . "/" . $this->namespace
    );
    return $dirs;
  }
  function findData($name) {
    $_ok = false;
    foreach ((array) $this->getConfigDir() as $_curr_path) {
      $path = $_curr_path . "/" . $name;
      if (file_exists($path)) {
        $_ok = true;
        break;
      }
    }
    if (!$_ok) {
      return NULL;
    }
    return $path;
  }
  function execute() {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE, $USER;
    global $_REQUEST;
    if ($this->securityRole != NULL) {
      initUser();
      $USER->forceLogged($this->securityRole);
    }
    $this->actionID = urlencode($_REQUEST[KEY_ACTION]);
    if (!file_exists(SRV_DIR . $SERVICE->serviceID . "/Action_$this->actionID.php")) {
      $this->actionID = $this->default_action;
    }
    require_once (SRV_DIR . $SERVICE->serviceID . "/Action_$this->actionID.php");
    $action = new Action();
    $res = $action->execute();
    $action = $res["action"];
    if ($action == "") {
      $this->render($res);
    } else {
      $this-> $action ($res);
    }
  }
  function nop(& $res) {
  }
  function redirect(& $res) {
    header("Location: " . $res["URL"]);
  }
  function render(&$res) {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE, $RENDER;
    require_once (EPS_CORE_DIR . "controls.inc");
    $this->pageID = $res["page"];
    if ($this->pageID == "*") {
      $PAGE = new TPage($res);
    } else {
      if (!file_exists(SRV_DIR . $this->serviceID . "/Page_$this->pageID.php")) {
        $this->pageID = $this->default_page;
      }
      require_once (SRV_DIR . $this->serviceID . "/Page_$this->pageID.php");
      $PAGE = new Page($res);
    }
    $RENDER = new TRender();
    $RENDER->process();
  }
}
?>