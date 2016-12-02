<?php
  if (session_status() == PHP_SESSION_NONE){
    session_start();
  } 
  if(session_destroy()) // Destroying All Sessions
  {
    header("Location: /FormazioneDocenti/index.php"); // Redirecting To Home Page
    die();
  }

?>