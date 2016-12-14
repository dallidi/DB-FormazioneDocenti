<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
  if (session_status() == PHP_SESSION_NONE){
    session_start();
    connectDB();
  } 
  if(session_destroy()) // Destroying All Sessions
  {
    internalRedirectTo("/index.php"); // Redirecting To Home Page
    disconnectDB();
    die();
  }

?>