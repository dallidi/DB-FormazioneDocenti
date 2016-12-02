<?php
  function writeUserError($message){
    error_log("USR;'".$$message);
  }
  
  // $level might be one of the following: INFO, ERROR
  function dbgTrace($level, $message){
    $trace = debug_backtrace()[0];
    error_log("DBG;".$level.";'".$trace["file"]."';".$trace["line"].
              ";'".$message."'");
  }
?>