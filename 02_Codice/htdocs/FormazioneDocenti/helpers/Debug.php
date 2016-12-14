<?php
  // require_once $_SERVER["DOCUMENT_ROOT"].
               // '/FormazioneDocenti/helpers/Debug.php';
  function writeUserError($message){
    error_log("USR;'".$$message);
  }
  
  // $level might be one of the following: INFO, ERROR
  function dbgTrace($message, $level = "INFO"){
    $trace = debug_backtrace()[0];
    $file = $trace["file"];
    $line = $trace["line"];
    error_log("DBG;$level;$file;$line;$message");
  }
  
?>
