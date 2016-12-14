<?php 
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php"; 
  require_once "$__ROOT__/tierData/DataModel/Docente.php";
  
  $db = null;
  function connectDB(){
    global $db;

    $servername = "localhost";
    $username = "";
    $password = "";

    try {
        $db = new PDO("mysql:host=$servername;dbname=FormazioneDocenti", $username, $password);
        // set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
    }
    return $db;
 }
  
  function disconnectDB(){
    global $db;

    $db = null;
  }

  function insertDocente($docente){
    global $db;
    
    $currDate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `Docenti`
              (cid, nome, cognome, 
               sigla, inizioQuadro, fineQadro, 
               via, viaNo,
               nap, localita, 
               telefono, email, lastUpdate)
            VALUES 
              ($docente->Cid, $docente->Nome, $docente->Cognome, 
               $docente->Sigla, $docente->InizioQ, $docente->FineQ, 
               $docente->Indirizzo->Via, $docente->Indirizzo->ViaNo, 
               $docente->Indirizzo->Nap, $docente->Indirizzo->Localita, 
               $docente->Contatto->Tel, $docente->Contatto->Email, $currDate)";
    $rows = $db->exec($sql);
  }
  
  function getDocenteById($id, &$docente){
    global $db;
    
    $sql = "SELECT * FROM `Docenti` 
            WHERE idDocente = " . $id;
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $docente->Id = $r['idDocente'];
      $docente->Cid = $r['cid'];
      $docente->Nome = $r['nome'];
      $docente->Cognome = $r['cognome'];
      $docente->Sigla = $r['sigla'];
      $docente->InizioQ = $r['inizioQuadro'];
      $docente->FineQ = $r['fineQuadro'];
      $docente->Indirizzo->Via = $r['via'];
      $docente->Indirizzo->ViaNo = $r['viaNo'];
      $docente->Indirizzo->Nap = $r['nap'];
      $docente->Indirizzo->Localita = $r['localita'];
      $docente->Contatto->Tel = $r['telefono'];
      $docente->Contatto->Email = $r['email'];
      $docente->LastUpdate = $r['lastUpdate'];
      return $docente->LastUpdate;
    } else {
      $id = 0;
    }
  }
  
  function getDocenteId($query){
    global $db;
    
    $query = '%' . $query . '%';
    $sql = "SELECT idDocente FROM `Docenti` 
            WHERE sigla LIKE '" . $query . "' OR 
                  cognome LIKE '" . $query . "' OR 
                  nome LIKE '" . $query . "' OR 
                  cid LIKE '" . $query ."'";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      return $r['idDocente'];
    } else {
      return 0;
    }
  }

  function getGroupById($idGruppo, &$group){
    global $db;

    $sql = "SELECT * 
            FROM Gruppi
            WHERE IdGruppo=$idGruppo";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $group->Id = $r["idGruppo"];
      $group->Descrizione = $r["descrizione"];
    }
  }
  
  function sqlToPhpDate($sqlDate, $format){
    return date($format, strtotime($sqlDate));
  }
  
  function phpDateToSql($date){
    return date_format($date, "Y-m-d");
  }
 
  function getAmbitoById($idAmbito, &$ambito){
   global $db;
   
   $sql = "SELECT * 
            FROM Ambiti
            WHERE idAmbito=$idAmbito";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $ambito->Descrizione = $r["descrizione"];
    }
  }

  function getOrganizzatoreById($idOrganizzatore, &$organizzatore){
    global $db;

    $sql = "SELECT * 
            FROM Organizzatori
            WHERE idOrganizzatore=$idOrganizzatore";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $organizzatore->Nome = $r["nome"];
    }
  }

  function getCorsoById($idCorso, &$corso){
    global $db;

    $sql = "SELECT * 
            FROM Corsi
            WHERE IdCorso=$idCorso";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $corso->Id = $r["idCorso"];
      $corso->Sigla = $r["sigla"];
      $corso->Titolo = $r["titolo"];
      $corso->Descrizione = $r["descrizione"];
      $corso->Tema = $r["tema"];
      $corso->PtrDescrizione = $r["ptrDescrizione"];
      getAmbitoById($r["Ambiti_idAmbito"], $corso->Ambito);
      getOrganizzatoreById($r["Organizzatori_idOrganizzatore"], $corso->Organizzatore);
    }
  }
  
  function getFrequenzaById($idFrequenza, &$frequenza){
    global $db;

    $sql = "SELECT * 
            FROM Frequenze
            WHERE idFrequenza=$idFrequenza";
    $rows = $db->query($sql);
    if ($r = $rows->fetch()){
      $frequenza->Id = $r["idFrequenza"];
      getDocenteById($r["Docenti_idDocente"], $frequenza->Docente);
      getCorsoById($r["Corsi_idCorso"], $frequenza->Corso);
      $frequenza->Inizio = date_create_from_format("Y-m-d", $r["inizio"]);
      $frequenza->Fine = date_create_from_format("Y-m-d", $r["fine"]);
      $frequenza->Contingente = intval($r["mgInContingente"])/2;
      $frequenza->NonContingente = intVal($r["mgNonContingente"])/2;
      $frequenza->PtrAttestato = $r["ptrAttestato"];
      $frequenza->PtrRapporto = $r["ptrRapporto"];
      $frequenza->Rapporto = $r["rapporto"];
    }
  }
  
  function convertDateFormat($dateStr, $fromFormat, $toFormat){
    return date_format(date_create_from_format($fromFormat, $dateStr), $toFormat);
  }
?>
