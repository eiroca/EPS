<?php
/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.inc
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2008 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5
 * @link http://www.eiroca.net
 */
class Service_MY extends TService {
  function Service_MY() {
    $this->namespace = "MY";
    $this->default_action = "CAT";
    $this->default_page = "CAT";
    $this->securityRole = "user";
  }
}
?>
