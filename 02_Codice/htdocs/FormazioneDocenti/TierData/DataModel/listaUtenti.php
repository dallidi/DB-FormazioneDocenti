<?php

  require_once "$__ROOT__/tierData/DbInterface/mysqli.php";

  //Esempi di chiamata:
  //$lista1 = new listaUtenti(null, nomegruppo, idgruppo);
  //$lista1 = new listaUtenti(nomeutente);
  //$lista1 = new listaUtenti(null, nomegruppo);
  //

  class listaUtenti {
    public $filtroNomeUtente = "*";
    public $filtroNomeGruppo = "*";
    public $filtroIdGruppo = "*";
    public $result;

    public function __construct($mysqli_conn, $argument1 = "*", $argument2 = "*", $argument3 = "*") {
      $sql = "
      SELECT * FROM utenti
      WHERE nomeUtente like '%' AND Gruppi_idGruppo like '%';
      ";

      $this->result = $mysqli_conn->query($sql);
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
