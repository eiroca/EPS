<?php
  global $CONTEXT;
  require_once ("../../lib/eps/eps.inc");
  initContext();
  $data = file_get_contents("php://input");
  $rr = $CONTEXT->touchCounter("req");
  $fname = $CONFIG["path_log"] . $rr . ".txt";
  $f = fopen($fname, "w+");
  fputs($f, $data);
  fclose($f);
?>
OK