<?php
  // require_once $_SERVER["DOCUMENT_ROOT"].
               // '/FormazioneDocenti/helpers/Debug.php';
  
  define("cDbgError", "ERROR");
  define("cDbgExcept", "EXCEPT");
  define("cDbgToDo", "TODO");
  define("cDbgInfo", "INFO");  
  
  function writeUserError($message){
    error_log("USR;'".$$message);
  }
  
  // $level might be one of the following: INFO, ERROR
  function dbgTrace($message, $level = cDbgInfo){
    $trace = debug_backtrace()[0];
    $file = $trace["file"];
    $line = $trace["line"];
    error_log("DBG;$level;$file;$line;$message");
  }
  
  function dbgExport($var, $level = cDbgInfo){
    $trace = debug_backtrace()[0];
    $file = $trace["file"];
    $line = $trace["line"];
    error_log("DBG;$level;$file;$line;".var_export($var, true));
  }

  function htmlTrace($message){
    $trace = debug_backtrace()[0];
    $file = $trace["file"];
    $line = $trace["line"];
    echo "<div class='dbgtrace'><p>$message</p><p>$file [$line]</p></div>";
  }

  function dbgHtml($message){
    echo "<p>$message</p>";
  }
  function dbgDump($var){
    echo var_dump($var);
  }
  
?>
