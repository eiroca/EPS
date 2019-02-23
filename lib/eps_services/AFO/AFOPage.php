<?php

/**
 * EIROCA PORTAL SYSTEM - Framework to build Mobile site - GPL3 - See licence in eps.php
 *
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2003-2019 eIrOcA - Enrico Croce & Simona Burzio
 * @version 0.5.3
 * @link http://www.eiroca.net
 */
class AFOPage extends TPage {

  var $conf;

  var $kind_id;

  function AFOPage(&$res) {
    parent::TPage($res);
    global $SERVICE;
    $this->kind_id = $this->getRequestVar('t', '1');
    $this->_cacheKey[] = $this->kind_id;
    $conf_file = $SERVICE->findData('index.ini');
    $this->conf = parse_ini_file($conf_file, true);
    $link = new TLink($this->conf['kind_' . $this->kind_id]['caption'], '#service#?s=AFO&amp;t=' . $this->kind_id, 'system_pin');
    $this->register_link('AFO_home', $link);
  }

  function getTitle() {
    return $this->conf['kind_' . $this->kind_id]['caption'];
  }

  function getName() {
    return 'Aforismi Service';
  }

}
?>