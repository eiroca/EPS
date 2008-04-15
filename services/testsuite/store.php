<?php
  global $CONTEXT, $CONFIG;
  require_once ("../../lib/eps/eps.inc");
  $data = file_get_contents("php://input");
  initContext();
  $rr = trim($CONTEXT->touchCounter("req"));
  $fname = $CONFIG["path_log"] . (int)$rr . ".txt";
  $f = fopen($fname, "w+");
  foreach($_REQUEST as $name => $value) {
    fwrite($f, $name . "=" . $value . "\n");
  }
  fclose($f);
?>
OK