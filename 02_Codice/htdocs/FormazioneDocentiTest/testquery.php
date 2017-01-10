<?php
  require $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
  require_once "$__ROOT__/tierData/DataModel/listaUtenti.php";

  $lista1 = new listaUtenti($mysqli_conn);
  $lista1->stampaLista();

  //$lista1 = new listaUtenti(null, nomegruppo, idgruppo);
  //$lista1 = new listaUtenti(nomeutente);
  //$lista1 = new listaUtenti(null, nomegruppo);
?>
