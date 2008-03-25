<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class Action extends TAction {
  function execute() {
    global $CONTEXT;
    $url = $_SESSION["url"];
    $_SESSION["user"] = null;
    $_SESSION["password"] = null;
    $_SESSION["url"] = null;
    if ($url == null) {
      $url = "index.php";
    }
    $CONTEXT->clearPortalMetadata();
    return array (
      "action" => "redirect",
      "URL" => $url
    );
  }
}
?>