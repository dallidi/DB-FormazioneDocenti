<?php
  // require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  $__ROOT__ = $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti";
  function internalRedirectTo($path){
    header("Location: ".makeUrl($path));
  }
  function makeUrl($path){
    return "/FormazioneDocenti$path";
  }
?>