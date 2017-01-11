<?php

  require_once "$__ROOT__/tierData/DbInterface/mysqli.php";

  //Esempi di chiamata:
  //$lista1 = new listaUtenti($mysqli_conn, null, nomegruppo, idgruppo);
  //$lista1 = new listaUtenti($mysqli_conn);
  //$lista1 = new listaUtenti($mysqli_conn, null, nomegruppo);

  class listaUtenti {
    public $filtroNomeUtente = "";
    public $filtroNomeGruppo = "";
    public $filtroIdGruppo = "";
    public $result;

    public function __construct($mysqli_conn, $filtroNomeUtente = "", $filtroNomeGruppo = "", $filtroIdGruppo = "") {
      $sql = "
      SELECT utenti.*
      FROM utenti, gruppi
      WHERE utenti.nomeUtente like'%$filtroNomeUtente%'
            AND gruppi.descrizione like '%$filtroNomeGruppo%'
            AND utenti.Gruppi_idGruppo like '%$filtroIdGruppo%'
            AND utenti.Gruppi_idGruppo = gruppi.idGruppo;
      ";

      $this->result = $mysqli_conn->query($sql);
      $this->filtroNomeUtente = $filtroNomeUtente;
      $this->filtroNomeGruppo = $filtroNomeGruppo;
      $this->filtroIdGruppo = $filtroIdGruppo;
    }

    public function stampaLista() {
      if ($this->result->num_rows > 0) {
        while($row = $this->result->fetch_assoc()) {
          echo "id: ".$row["idUtente"]." - Name: ".$row["nomeUtente"]."<br>";
        }
      } else {
        echo "0 results";
      }
    }

  }

?>
