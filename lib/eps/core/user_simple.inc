<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
require_once (EPS_DIR . "core/user.inc");
class TUser extends TAbstractUser {
  function forceLogged($role = NULL) {
    unset ($this->data, $this->user);
    list ($this->user, $pwd) = $this->getUserCredentials();
    if (!isset ($this->user)) {
      $this->gotoLogin();
    } else {
      $this->load();
      if ($this->data == NULL) {
        $this->gotoLogin();
      }
      $password = $this->data["password"];
      if ($password != null) {
        $result = crypt($pwd, $pwd);
      } else {
        $result = true;
      }
      if ($role != NULL) {
        if (!in_array($role, $this->data["role"])) {
          $this->gotoLogin();
        }
      }
      if ($result != $password) {
        $this->gotoLogin();
      } else {
        $_SESSION["url"] = null;
      }
    }
  }
  function getUserCredentials() {
    return array (
      $_SESSION["user"],
      $_SESSION["password"]
    );
  }
  function gotoLogin() {
    global $CONFIG;
    $url = $_SESSION["url"];
    if ($url == null) {
      $url = $_SERVER['REQUEST_URI'];
      $qs = $_SERVER['QUERY_STRING'];
      if ($qs) {
        $url = $url . "?" . $qs;
      }
      $_SESSION["url"] = $url;
    }
    header("Location: " . $CONFIG["page_login"]);
    exit;
  }
}
?>