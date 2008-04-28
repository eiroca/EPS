<?php
  global $CONTEXT, $CONFIG;
  require_once ("../../lib/eps/eps.inc");
  $data = file_get_contents("php://input");
  initContext();
  $rr = trim($CONTEXT->touchCounter("req"));
  $fname = $CONFIG["path_log"] . (int)$rr . ".txt";
  $f = fopen($fname, "w+");
  if ($_REQUEST["_P"] != "") {
    foreach($_REQUEST as $name => $value) {
      fwrite($f, $name . "=" . $value . "\n");
    }
  }
  else {
    fwrite($f, $data);
  }
  fclose($f);
?>
OK