<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class TPortalMetadata {
  var $timestamp = NULL;
  var $rid = NULL;
  var $exit_url = NULL;
  var $exit_caption = NULL;
  var $exit_icon = NULL;
  function TPortalMetadata() {
    global $CONTEXT;
    $this->timestamp = time();
    $this->rid = "R" . $CONTEXT->touchCounter("RID");
  }
  function store() {
    $_SESSION["system_portalMetadata"] = $this;
  }
}
class TRequest extends TContext {
  var $portalMetadata;
  var $renderClass;
  function TRequest() {
    parent :: TContext();
    header("P3P: CP=\"STA\"");
    session_name("SID");
    session_start();
  }
  function clearPortalMetadata() {
    $_SESSION["system_portalMetadata"] = NULL;
  }
  function loadPortalMetadata() {
    $portalMetadata = $_SESSION["system_portalMetadata"];
    if ($portalMetadata == NULL) {
      $portalMetadata = new TPortalMetadata();
      $portalMetadata->store();
    }
    return $portalMetadata;
  }
  function loadService($id) {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    $servicePath = SRV_DIR . $id . DIR_SEP. "Service.php";
    if (!file_exists($servicePath)) {
      return null;
    } else {
      require_once (EPS_CORE_DIR . "services.inc");
      require_once ($servicePath);
      $method = "Service_$id";
      $serv = new $method ();
      $serv->serviceID = $id;
      return $serv;
    }
  }
  function process($serviceID = NULL, $defServiceID = NULL, $renderClass = NULL, $userAgent = NULL) {
    global $CONFIG, $CONTEXT, $HANDSET, $SERVICE, $PAGE;
    initHandset($userAgent);
    $this->portalMetadata = $this->loadPortalMetadata();
    if (!$renderClass) {
      $this->renderClass = $this->decodeRenderClass();
    } else {
      $this->renderClass = $renderClass;
    }
    $serviceID = $this->decodeServiceID($serviceID, $defServiceID);
    $SERVICE = $this->loadService($serviceID);
    if ($SERVICE == null) {
      $this->redirect($CONFIG["homepage"]);
    }
    else {
      $SERVICE->execute();
    }
    $this->logAccess(smarty_core_get_microtime("", $this) - $this->_begintime, $serviceID);
  }
}
?>