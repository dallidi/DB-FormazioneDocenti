<?php
  $cfg['username'] = 'root';
  $cfg['password'] = '';
  $cfg['host'] = 'localhost';
  $cfg['db'] = 'FormazioneDocenti';

  $mysqli_conn = new mysqli($cfg['host'], $cfg['username'], $cfg['password'], $cfg['db']);
  if (mysqli_connect_errno()) {
    echo 'Errore di connessione ('.mysqli_connect_errno.')';
    die();
  }
?>
