<?php
  require $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
  require_once "$__ROOT__/tierData/DataModel/listaUtenti.php";
  require_once "$__ROOT__/tierData/dbInterface/CommonDB.php";

  $db = connectDB();
  $lista = array();

  //$lista1 = new listaUtenti($mysqli_conn, "test1");
  //$lista1 = new listaUtenti($mysqli_conn, null, "Amministratori");
  $lista1 = new ListaUtenti($lista, $mysqli_conn, "test0", null, 3, ">");
  //$lista1 = new listaUtenti($mysqli_conn, "test", "Docenti", 1);
  $lista1->stampaLista();
?>
