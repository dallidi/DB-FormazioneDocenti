<?php

  require_once "$__ROOT__/tierData/DbInterface/mysqli.php";
  require_once "$__ROOT__/tierData/dbInterface/CommonDB.php";

  //Esempi di chiamata:
  //$lista1 = new listaUtenti($mysqli_conn, null, nomegruppo, idgruppo);
  //$lista1 = new listaUtenti($mysqli_conn);
  //$lista1 = new listaUtenti($mysqli_conn, null, nomegruppo);

  class ListaUtenti {
    public $filtroNomeUtente = "";
    public $filtroNomeGruppo = "";
    public $filtroIdGruppo = "";
    public $result;
    public $lista_utenti = array();

    public function __construct(&$lista_utenti, $mysqli_conn, $filtroNomeUtente = "", $filtroNomeGruppo = "", $filtroIdGruppo = "", $operazione = "=") {
      global $db;
      $sql = "
      SELECT utenti.*
      FROM utenti, gruppi
      WHERE utenti.nomeUtente like'%$filtroNomeUtente%'
            AND gruppi.descrizione like '%$filtroNomeGruppo%'
            AND utenti.Gruppi_idGruppo $operazione '%$filtroIdGruppo%'
            AND utenti.Gruppi_idGruppo = gruppi.idGruppo;
      ";

      $this->result = $db->query($sql);
      $this->filtroNomeUtente = $filtroNomeUtente;
      $this->filtroNomeGruppo = $filtroNomeGruppo;
      $this->filtroIdGruppo = $filtroIdGruppo;
      $this->lista_utenti = $this->result->fetchAll();
    }

    public function getLista() {
      return $this->lista_utenti;
    }

    public function stampaLista() {
      echo '<pre>';
      print_r($this->lista_utenti);
      echo '</pre>';
    }

  }

?>
